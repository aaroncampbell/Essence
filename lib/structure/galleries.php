<?php
function essence_wp_head() {
	?>
<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function($){
		$("a.lightbox").colorbox();
		$(".gallery").each(function(){
			var group = Math.floor(Math.random()*10000);
			$(this).find("a").colorbox({
				rel: group,
				current: "<?php echo sprintf( esc_js( 'Image %1$s of %2$s', 'essence' ), '{current}', '{total}' ); ?>",
				close: "<?php echo esc_js( 'Close', 'essence' ); ?>",
				next: "<?php echo esc_js( 'Next', 'essence' ); ?>",
				previous: "<?php echo esc_js( 'Previous', 'essence' ); ?>",
				title: function(){
					var galleryItem = $(this).parents('.gallery-item').find('dd');
					if ( galleryItem.size() ) {
						return galleryItem.html();
					} else {
						return ' ';
					}
				}
			});
		});
	});
// ]]>
</script>
	<?php
}
add_action( 'wp_head', 'essence_wp_head' );

function essence_attachment_link( $link, $id ) {
	if ( is_feed() || is_admin() )
		return $link;

	$post = get_post( $id );

	if ( 'image' == substr( $post->post_mime_type, 0, 5 ) )
		return wp_get_attachment_url( $id );
	else
		return $link;
}
add_filter( 'attachment_link', 'essence_attachment_link', 10, 2 );
