<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="left" valign="top" class="subforum-search">
                <input type="hidden" name="action" value="bbp-search-request" />
                <div style="float:left; padding: 3px 0 0 30px;"><input tabindex="<?php bbp_tab_index(); ?>" type="text" id="bbp_search" name="bbp_search" value="<?php echo (strlen(esc_attr(bbp_get_search_terms()))>0)  ? esc_attr(bbp_get_search_terms()) : 'Search this forumn..'  ; ?>" onfocus="if (this.value == 'Search this forumn..') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search this forumn..';}"></div>
                <div align="right"><img id="search-close" src="<?php bloginfo('template_directory'); ?>/images/close-button.png" width="14" height="14" style="margin:5px 5px 0px 0px;cursor:pointer;"></div>
            </td>
        </tr>
        <!--<tr>
            <td align="right" valign="top" class="padding-top10 greentext12"><input tabindex="<?php bbp_tab_index(); ?>" class="green-button" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Search', 'knowtion' ); ?>" /></td>
        </tr>-->
    </table>
</form>

