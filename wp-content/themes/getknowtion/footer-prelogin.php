<?php
/*
 * footer-prelogin.php 
 * This is footer for prelogin page
 * 
 */
?>
            <tr>
                <td valign="middle" align="left" id="footer">
                    <div class="about"><a class="footer-white-link" href="<?php echo HOME_URL . "/about-us";?>"><?php _e('ABOUT','knowtion');?></a></div>
                    <div class="help"><a class="footer-white-link" href="<?php echo HOME_URL . "/help";?>"><?php _e('HELP','knowtion');?></a></div>
                    <div class="faq"><a class="footer-white-link" href="<?php echo HOME_URL . "/faqs";?>"><?php _e('FAQ','knowtion');?></a></div>
                    <div class="contactus"><a class="footer-white-link" href="<?php echo HOME_URL . "/contact-us";?>"><?php _e('CONTACT US','knowtion');?></a></div>
                    <div class="copyright">Knowtion &copy; 2013</div>
                </td>
            </tr>
        </table>
    </div>
<?php wp_footer();?>
    </body>
</html>
<div id="popupmodel"></div>
<div id="loader" align="center">
        <img src="<?php echo THEME_DIR . '/images/loader.png';?>" height="32" width="110" border="0"/>
</div>
