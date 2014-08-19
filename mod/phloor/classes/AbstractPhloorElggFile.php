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
abstract class AbstractPhloorElggFile extends ElggObject
//implements IPhloorElggFile
{
    public function hasFile() {
        return isset($this->file) && !empty($this->file) &&
        file_exists($this->file) && is_file($this->file);
    }

    /**
     * Getter for file
     */
    public function getFile() {
        return $this->get('file');
    }

    /**
     * Setter for file
     */
    public function setFile($file) {
        $this->set('file', $file);
    }
}