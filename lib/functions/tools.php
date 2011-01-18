<?php
/**
 * For use with debugging
 */
if ( !function_exists('dump') ) {
	/**
	 * To be used like a more flexible more developer friendly var_dump.
	 * Basically you can pass a variable to dump as well as a title and choose
	 * whether it returns that data to you to echo out or Use this as a var_dump
	 */
	function dump($v, $title = '', $format = 'html', $return = false ) {
		$format = strtolower( $format );
		if ( ! in_array( $format, array( 'html', 'plaintext', 'htmlcomment' ) ) ) {
			$format = 'html';
		}
		if ( 'html' == $format ) {
			$before_title	= '<h4>';
			$after_title	= '</h4>';
			$before_content	= '<pre>';
			$after_content	= '</pre>';
		} else {
			$after_title = $before_title = '::';
			$after_content = $before_content = "\r\n";
		}
		if ( ! empty( $title ) ) {
			$title = $before_title . htmlentities($title) . $after_title;
		}
		ob_start();
		var_dump( $v );
		$v = ob_get_clean();
		if ( 'html' == $format ) {
			$v = esc_html( $v );
		}
		$v = $title . $before_content . $v . $after_content;
		if ( 'htmlcomment' == $format ) {
			$v = "<!--\r\n{$v}\r\n-->";
		}
		if ( $return ) {
			return $v;
		}
		echo $v;
	}
}
