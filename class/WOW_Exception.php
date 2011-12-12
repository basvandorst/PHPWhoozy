<?php 
/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * WOW_Exception
 * 
 * All API-errors will call this exception handler
 * 
 * @author Bas van Dorst <info@basvandorst.nl>
 * @version 0.1
 * @package WOW_Library
 */

class WOW_Exception extends Exception {
	/**
	 * Constructor
	 *
	 * @param int $code
	 * @param string $message
	 */
	public function __construct($code, $message) {
		parent::__construct( (String) $message, (int) $code);
	}
}
?>