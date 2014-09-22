<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 */
    get_header();    
?>   
   <tr>
   		<td align="center" valign="middle">
        <div style="padding:20px;">
        	<div class="call-box">
            	<div style="padding:35px;">
                	<table border="0" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td align="center" valign="top" colspan="3">
                            	<div style="position:relative;height:50px;width:50px;">
                                	<img src="<?php echo THEME_DIR."/images/user9.jpg"; ?>" width="50" height="50"/>
                                    <div class="frame"></div>                    	
                                </div>
                            </td>
                        </tr>
                        <tr><td style="height:10px;"></td></tr>
                        <tr>
                        	<td align="center" valign="top" colspan="3">
                            	<div class="font-username">Molly Fox</div>
                            </td>
                        </tr>
                        <tr>
                        	<td align="center" valign="top" colspan="3">
                            	<div class="font-country">United States</div>
                            </td>
                        </tr>
                        <tr><td style="height:25px;"></td></tr>
                        <tr>
                        	<td align="left" valign="top">
                            	<div class="btnbg" style="padding:0px 15px;">
                            		<input type="button" value="Accept" class="btn-on-off" name="vedioonnoff">
                            	</div>
                            </td>
                            <td><div style="width:20px;"></div></td>
                            <td align="left" valign="top">
                            	<div class="btnbg-cancel">
                            		<input type="button" value="Accept" class="btn-cancel" name="vedioonnoff">
                            	</div>
                            </td>
                        </tr>
                    </table>                	
                </div>
            </div>
        </div>        	
        </td>
   </tr>
<?php
    get_footer();
?>