<?php
/*
 * footer-prelogin.php 
 * This is footer for prelogin page
 * 
 */
?>
            <tr>
                <td valign="middle" align="left" id="footer">
                    <div class="about"><a class="footer-white-link" href="<?php echo site_url() . "/about-us";?>">ABOUT</a></div>
                    <div class="help"><a class="footer-white-link" href="<?php echo site_url() . "/help";?>">HELP</a></div>
                    <div class="faq"><a class="footer-white-link" href="<?php echo site_url() . "/faqs";?>">FAQ</a></div>
                    <div class="contactus"><a class="footer-white-link" href="<?php echo site_url() . "/contact-us";?>">CONTACT US</a></div>
                    <div class="copyright">Knowtion &copy; 2013</div>
                </td>
            </tr>
        </table>
    </div>
<?php wp_footer();?>
    </body>
</html>
<div id="loader" align="center">
    <img src="<?php echo THEME_DIR;?>/images/loader.gif" width="32" height="32" />
    <label>Please wait...</label>
</div>