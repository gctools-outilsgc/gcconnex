<?php
/*****************************************************************************
 * Phloor                                                                    *
 *                                                                           *
 * Copyright (C) 2011 Alois Leitner                                          *
 *                                                                           *
 * This program is free software: you can redistribute it and/or modify      *
 * it under the terms of the GNU General Public License as published by      *
 * the Free Software Foundation, either version 2 of the License, or         *
 * (at your option) any later version.                                       *
 *                                                                           *
 * This program is distributed in the hope that it will be useful,           *
 * but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 * GNU General Public License for more details.                              *
 *                                                                           *
 * You should have received a copy of the GNU General Public License         *
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.     *
 *                                                                           *
 * "When code and comments disagree both are probably wrong." (Norm Schryer) *
 *****************************************************************************/
?>
<?php

/**
 *
 */
abstract class AbstractPhloorElggImage extends ElggObject
//implements IPhloorElggImage
{
    public function delete() {
        $return = $this->deleteImage();

        $return = $return && parent::delete();

        return $return;
    }

    public function hasImage() {
        return isset($this->image) && !empty($this->image) &&
        file_exists($this->image) && is_file($this->image);
    }

    protected function deleteImage() {
        if(!$this->hasImage()) {
            return true;
        }

        $return = @unlink($this->image);

        $this->image = '';

        return $return;
    }

	public function getImageURL() {
	    $thumb_url = "mod/phloor/thumbnail.php?guid={$this->guid}";

		return elgg_normalize_url($thumb_url);
	}


	/*public function getIconURL($size = 'small') {
	    $sizes = array('tiny', 'small', 'medium', 'large');
		if(!in_array($size, $sizes)) {
			$size = 'small';
		}

		if($this->hasImage()) {
		    return $this->getImageURL();
		}


		return parent::getIconURL($size);
	}*/

    /**
     * Getter for image
     */
    public function getImage() {
        return $this->get('image');
    }

    /**
     * Setter for image
     */
    protected function setImage($image) {
        $this->set('image', $image);
    }

    /**
     * Getter for image
     */
    public function getMime() {
        return $this->get('mime');
    }

    /**
     * Setter for image
     */
    protected function setMime($image) {
        $this->set('mime', $image);
    }
}