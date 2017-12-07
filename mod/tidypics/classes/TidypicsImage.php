<?php
/**
 * Tidypics Image class
 *
 * @package TidypicsImage
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */


class TidypicsImage extends ElggFile {
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "image";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}

	/**
	 * Save the image
	 *
	 * @warning container_guid must be set first
	 *
	 * @param array $data
	 * @return bool
	 */
	public function save($data = null) {

		if (!parent::save()) {
			return false;
		}

		if ($data) {
			// new image
			$this->simpletype = "image";
			$this->saveImageFile($data);
			$this->saveThumbnails();
			$this->extractExifData();
		}

		return true;
	}

	/**
	 * Delete image
	 *
	 * @return bool
	 */
	public function delete() {

		// check if batch should be deleted
		$batch = elgg_get_entities_from_relationship(array(
			'relationship' => 'belongs_to_batch',
			'relationship_guid' => $this->guid,
			'inverse_relationship' => false,
		));
		if ($batch) {
			$batch = $batch[0];
			$count = elgg_get_entities_from_relationship(array(
				'relationship' => 'belongs_to_batch',
				'relationship_guid' => $batch->guid,
				'inverse_relationship' => true,
				'count' => true,
			));
			if ($count == 1) {
				// last image so delete batch
				$batch->delete();
			}
		}

		$this->removeThumbnails();

		$album = get_entity($this->container_guid);
		if ($album) {
			$album->removeImage($this->guid);
		}

		// update quota
		$owner = $this->getOwnerEntity();
		$owner->image_repo_size = (int)$owner->image_repo_size - $this->getSize();

		return parent::delete();
	}

	/**
	 * Get the title of the image
	 *
	 * @return string
	 */
	public function getTitle() {
		if ($this->title) {
			return $this->title;
		} else {
			return $this->originalfilename;
		}
	}

	/**
	 * Get the URL for the web page of this image
	 *
	 * @return string
	 */
	public function getURL() {
		$title = elgg_get_friendly_title($this->getTitle());
		$url = "photos/image/$this->guid/$title";
		return elgg_normalize_url($url);
	}

	/**
	 * Get the src URL for the image
	 *
	 * @return string
	 */
	public function getIconURL($size = 'small') {
		if ($size == 'tiny') {
			$size = 'thumb';
		}
		return elgg_normalize_url("photos/thumbnail/$this->guid/$size/");
	}

	/**
	 * Get the view information for this image
	 *
	 * @param $viewer_guid The guid of the viewer
	 * @return array with number of views, number of unique viewers, and number of views for this viewer
	 */
	public function getViewInfo($viewer_guid = 0) {
		if ($viewer_guid == 0) {
			$viewer_guid = elgg_get_logged_in_user_guid();
		}

		$views = elgg_get_annotations(array(
			'guid' => $this->getGUID(),
			'annotation_name' => 'tp_view',
			'limit' => 0,
		));
		if ($views) {
			$total_views = count($views);

			if ($this->getOwnerGUID() == $viewer_guid) {
				// get unique number of viewers
				$diff_viewers = array();
				foreach ($views as $view) {
					$diff_viewers[$view->owner_guid] = 1;
				}
				$unique_viewers = count($diff_viewers);
			} else if ($viewer_guid) {
				// get the number of times this user has viewed the photo
				$my_views = 0;
				foreach ($views as $view) {
					if ($view->owner_guid == $viewer_guid) {
						$my_views++;
					}
				}
			}

			$view_info = array("total" => $total_views, "unique" => $unique_viewers, "mine" => $my_views);
		}
		else {
			$view_info = array("total" => 0, "unique" => 0, "mine" => 0);
		}

		return $view_info;
	}

	/**
	 * Add a view to this image
	 *
	 * @param $viewer_guid
	 * @return void
	 */
	public function addView($viewer_guid = 0) {
		if ($viewer_guid == 0) {
			$viewer_guid = elgg_get_logged_in_user_guid();
		}

		if ($viewer_guid != $this->owner_guid && tp_is_person()) {
			create_annotation($this->getGUID(), "tp_view", "1", "integer", $viewer_guid, ACCESS_PUBLIC);
		}
	}


	/**
	 * Set the internal filenames
	 */
	protected function setOriginalFilename($originalName) {
		$prefix = "image/" . $this->container_guid . "/";
		$filestorename = elgg_strtolower(time() . $originalName);
		$this->setFilename($prefix . $filestorename);
		$this->originalfilename = $originalName;
	}

	/**
	 * Auto-correction of image orientation based on exif data
	 *
	 * @param array $data
	 */
	protected function OrientationCorrection($data) {
		// catch for those who don't have exif module loaded
		if (!is_callable('exif_read_data')) {
			return;
		}
		$exif = exif_read_data($data['tmp_name']);
		$orientation = isset($exif['Orientation']) ? $exif['Orientation'] : 0;
		if($orientation != 0 || $orientation != 1) {

			$imageLib = elgg_get_plugin_setting('image_lib', 'tidypics');

			if ($imageLib == 'ImageMagick') {
				// ImageMagick command line
				$im_path = elgg_get_plugin_setting('im_path', 'tidypics');
				if (!$im_path) {
					$im_path = "/usr/bin/";
				}
				if (substr($im_path, strlen($im_path)-1, 1) != "/") {
					$im_path .= "/";
				}

				$filename = $data['tmp_name'];
				$command = $im_path . "mogrify -auto-orient $filename";
				$output = array();
				$ret = 0;
				exec($command, $output, $ret);
			} else if ($imageLib == 'ImageMagickPHP') {
				// imagick php extension
				$rotate = false;
				$flop = false;
				$angle = 0;
				switch($orientation) {
					case 2:
						$rotate = false;
						$flop = true;
						break;
					case 3:
						$rotate = true;
						$flop = false;
						$angle = 180;
						break;
					case 4:
						$rotate = true;
						$flop = true;
						$angle = 180;
						break;
					case 5:
						$rotate = true;
						$flop = true;
						$angle = 90;
						break;
					case 6:
						$rotate = true;
						$flop = false;
						$angle = 90;
						break;
					case 7:
						$rotate = true;
						$flop = true;
						$angle = -90;
						break;
					case 8:
						$rotate = true;
						$flop = false;
						$angle = -90;
						break;
					default:
						$rotate = false;
						$flop = false;
						break;
				}
				$imagick = new Imagick();
				$imagick->readImage($data['tmp_name']);
				if ($rotate) {
					$imagick->rotateImage('#000000', $angle);
				}
				if ($flop) {
					$imagick->flopImage();
				}
				$imagick->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
				$imagick->writeImage($data['tmp_name']);
				$imagick->clear();
				$imagick->destroy(); 
			} else {
				// make sure the in memory image size does not exceed memory available
				$imginfo = getimagesize($data['tmp_name']);
				$requiredMemory1 = ceil($imginfo[0] * $imginfo[1] * 5.35);
				$requiredMemory2 = ceil($imginfo[0] * $imginfo[1] * ($imginfo['bits'] / 8) * $imginfo['channels'] * 2.5);
				$requiredMemory = (int)max($requiredMemory1, $requiredMemory2);

				$mem_avail = elgg_get_ini_setting_in_bytes('memory_limit');
				$mem_used = memory_get_usage();

				$mem_avail = $mem_avail - $mem_used - 2097152; // 2 MB buffer
				if ($requiredMemory < $mem_avail) {
					$image = imagecreatefromstring(file_get_contents($data['tmp_name']));
					$rotate = false;
					$flip = false;
					$angle = 0;
					switch($orientation) {
						case 2:
							$rotate = false;
							$flip = true;
							break;
						case 3:
							$rotate = true;
							$flip = false;
							$angle = 180;
							break;
						case 4:
							$rotate = true;
							$flip = true;
							$angle = 180;
							break;
						case 5:
							$rotate = true;
							$flip = true;
							$angle = -90;
							break;
						case 6:
							$rotate = true;
							$flip = false;
							$angle = -90;
							break;
						case 7:
							$rotate = true;
							$flip = true;
							$angle = 90;
							break;
						case 8:
							$rotate = true;
							$flip = false;
							$angle = 90;
							break;
						default:
							$rotate = false;
							$flip = false;
							break;
					}
					if ($rotate) {
						$image = imagerotate($image, $angle, 0);
						imagejpeg($image, $data['tmp_name']);
					}
					if ($flip) {
						$mem_avail = elgg_get_ini_setting_in_bytes('memory_limit');
						$mem_used = memory_get_usage();

						$mem_avail = $mem_avail - $mem_used - 2097152; // 2 MB buffer
						if (($requiredMemory) < $mem_avail) {
							$width = imagesx($image);
							$height = imagesy($image);
							$src_x = 0;
							$src_y = 0;
							$src_width = $width;
							$src_height = $height;
							$src_x = $width -1;
							$src_width = -$width;
							$imgdest = imagecreatetruecolor($width, $height);
							imagecopyresampled($imgdest, $image, 0, 0, $src_x, $src_y, $width, $height, $src_width, $src_height);
							imagejpeg($imgdest, $data['tmp_name']);
							imagedestroy($imgdest);
						}
					}
					imagedestroy($image);
				}
			}
		}
	}

	/**
	 * Save the uploaded image
	 *
	 * @param array $data
	 */
	protected function saveImageFile($data) {
		$this->checkUploadErrors($data);

		$this->OrientationCorrection($data);

		// we need to make sure the directory for the album exists
		// @note for group albums, the photos are distributed among the users
		$dir = tp_get_img_dir($this->getContainerGUID());
		if (!file_exists($dir)) {
			mkdir($dir, 0755, true);
		}

		// move the uploaded file into album directory
		$this->setOriginalFilename($data['name']);
		$filename = $this->getFilenameOnFilestore();
		$result = move_uploaded_file($data['tmp_name'], $filename);
		if (!$result) {
			return false;
		}

		$owner = $this->getOwnerEntity();
		$owner->image_repo_size = (int)$owner->image_repo_size + $this->getSize();

		return true;
	}

	/**
	 * Need to restore sanity to this function
	 * @param type $data
	 */
	protected function checkUploadErrors($data) {
		// check for upload errors
		if ($data['error']) {
			if ($data['error'] == 1) {
				trigger_error('Tidypics warning: image exceeded server php upload limit', E_USER_WARNING);
				throw new Exception(elgg_echo('tidypics:image_mem'));
			} else {
				throw new Exception(elgg_echo('tidypics:unk_error'));
			}
		}

		// must be an image
		if (!tp_upload_check_format($data['type'])) {
			throw new Exception(elgg_echo('tidypics:not_image'));
		}

		// make sure file does not exceed memory limit
		if (!tp_upload_check_max_size($data['size'])) {
			throw new Exception(elgg_echo('tidypics:image_mem'));
		}

		// make sure the in memory image size does not exceed memory available
		$imginfo = getimagesize($data['tmp_name']);
		$requiredMemory1 = ceil($imginfo[0] * $imginfo[1] * 5.35);
		$requiredMemory2 = ceil($imginfo[0] * $imginfo[1] * ($imginfo['bits'] / 8) * $imginfo['channels'] * 2.5);
		$requiredMemory = (int)max($requiredMemory1, $requiredMemory2);
		$image_lib = elgg_get_plugin_setting('image_lib', 'tidypics');
		if (!tp_upload_memory_check($image_lib, $requiredMemory)) {
			trigger_error('Tidypics warning: image memory size too large for resizing so rejecting', E_USER_WARNING);
			throw new Exception(elgg_echo('tidypics:image_pixels'));
		}

		// make sure file fits quota
		if (!tp_upload_check_quota($data['size'], elgg_get_logged_in_user_guid())) {
			throw new Exception(elgg_echo('tidypics:cannot_upload_exceeds_quota'));
		}
	}

	/**
	 * Save the image thumbnails
	 */
	protected function saveThumbnails() {
		elgg_load_library('tidypics:resize');

		$imageLib = elgg_get_plugin_setting('image_lib', 'tidypics');

		$prefix = "image/" . $this->container_guid . "/";
		$filename = $this->getFilename();
		$filename = substr($filename, strrpos($filename, '/') + 1);

		if ($imageLib == 'ImageMagick') {
			// ImageMagick command line
			if (tp_create_im_cmdline_thumbnails($this, $prefix, $filename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails - ImageMagick command line', E_USER_WARNING);
			}
		} else if ($imageLib == 'ImageMagickPHP') {
			// imagick php extension
			if (tp_create_imagick_thumbnails($this, $prefix, $filename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails - ImageMagick PHP', E_USER_WARNING);
			}
		} else {
			if (tp_create_gd_thumbnails($this, $prefix, $filename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails - GD', E_USER_WARNING);
			}
		}
	}

	/**
	 * Get the image data of a thumbnail
	 *
	 * @param string $size
	 * @return string
	 */
	public function getThumbnail($size) {
		switch ($size) {
			case 'thumb':
				$thumb = $this->thumbnail;
				break;
			case 'small':
				$thumb = $this->smallthumb;
				break;
			case 'large':
				$thumb = $this->largethumb;
				break;
			default:
				return '';
				break;
		}

		if (!$thumb) {
			return '';
		}

		$file = new ElggFile();
		$file->owner_guid = $this->getOwnerGUID();
		$file->setFilename($thumb);
		return $file->grabFile();
	}

	public function getImage() {
		return $this->grabFile();
	}

	/**
	 * Extract EXIF Data from image
	 *
	 * @warning image file must be saved first
	 */
	public function extractExifData() {
		elgg_load_library('tidypics:exif');
		td_get_exif($this);
	}

	/**
	 * Has the photo been tagged with "in this photo" tags
	 *
	 * @return true/false
	 */
	public function isPhotoTagged() {
		$num_tags = elgg_get_annotations(array('guid' => $this->getGUID(), 'type' => 'object', 'subtype' => 'image', 'annotation_name' => 'phototag', 'count' => true));
		if ($num_tags > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get an array of photo tag information
	 *
	 * @return array
	 */
	public function getPhotoTags() {

		$tags = array();
		$annotations = elgg_get_annotations(array(
			'guid' => $this->getGUID(),
			'annotation_name' => 'phototag',
		));
		foreach ($annotations as $annotation) {
			$tag = unserialize($annotation->value);
			$tag->annotation_id = $annotation->id;
			$tags[] = $tag;
		}

		return $tags;
	}

	/**
	 * Remove thumbnails - usually in preparation for deletion
	 *
	 * The thumbnails are not actually ElggObjects so we create
	 * temporary objects to delete them.
	 */
	protected function removeThumbnails() {
		$thumbnail = $this->thumbnail;
		$smallthumb = $this->smallthumb;
		$largethumb = $this->largethumb;

		//delete standard thumbnail image
		if ($thumbnail) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->getOwnerGUID();
			$delfile->setFilename($thumbnail);
			$delfile->delete();
		}
		//delete small thumbnail image
		if ($smallthumb) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->getOwnerGUID();
			$delfile->setFilename($smallthumb);
			$delfile->delete();
		}
		//delete large thumbnail image
		if ($largethumb) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->getOwnerGUID();
			$delfile->setFilename($largethumb);
			$delfile->delete();
		}
	}
}
