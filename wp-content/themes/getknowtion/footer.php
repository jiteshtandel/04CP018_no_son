            <tr>
                <td valign="middle" align="left" id="footer">
                    <div class="about"><a class="footer-white-link" target="_blank" href="<?php echo site_url() . "/about-us";?>">ABOUT</a></div>
                    <div class="help"><a class="footer-white-link" target="_blank" href="<?php echo site_url() . "/help";?>">HELP</a></div>
                    <div class="faq"><a class="footer-white-link" target="_blank" href="<?php echo site_url() . "/faqs";?>">FAQ</a></div>
                    <div class="contactus"><a class="footer-white-link" target="_blank" href="<?php echo site_url() . "/contact-us";?>">CONTACT US</a></div>
                    <div class="copyright">Knowtion &copy; 2013</div>
                </td>
            </tr>
    </table>
</div>
<?php wp_footer();?>
<!-- end container --> 
<!--
<div id="outgoingcallpopup" style="display:none;border:5px solid black;width:200px;height:100px;background-color: gray;position:absolute;">
    <img src="" width="32" height="32" border="0"/>
    <input type="button" id="callcancel" value="End" style="display:block;"/>
</div>
-->
<!--
<div id="incomingcallpopup" style="display:none;border:5px solid black;width:200px;height:100px;background-color: gray;position:absolute;">
    <img src="" width="32" height="32" border="0"/>
    <input type="button" id="callacceptbutton" value="Accept" style="display:block;"/>
    <input type="button" id="rejectcallbutton" value="Reject" style="display:block;"/>
</div>
-->
<div id="outgoingcallpopup" class="call-box">
    <div style="padding:35px;">
            <table cellspacing="0" cellpadding="0" border="0">
            <tbody><tr>
                    <td valign="top" align="center" colspan="3">
                    <div style="position:relative;height:50px;width:50px;">
                            <img width="50" height="50" src="">
                        <div class="frame"></div>                    	
                    </div>
                </td>
            </tr>
            <tr><td style="height:10px;"></td></tr>
            <tr>
                    <td valign="top" align="center" colspan="3">
                        <div class="font-username"><span></span</div>
                </td>
            </tr>
            <!--<tr>
                <td valign="top" align="center" colspan="3">
                    <div class="font-country">United States</div>
                </td>
            </tr>-->
            <tr><td style="height:25px;"></td></tr>
            <tr>
                <td valign="top" align="center" colspan="3">
                    <div id="callcancel" class="btnbg-cancel" style="width:65px;">
                            <input type="button" name="vedioonnoff" class="btn-cancel" value="End" style="padding-right:0px;padding-bottom:0px;padding-left: 22px;padding-top:0px;background-color: #6d6e70;">
                    </div>
                </td>
            </tr>
        </tbody></table>                	
    </div>
</div>
<div id="incomingcallpopup" class="call-box">
    <div style="padding:35px;">
            <table cellspacing="0" cellpadding="0" border="0">
            <tbody><tr>
                    <td valign="top" align="center" colspan="3">
                    <div style="position:relative;height:50px;width:50px;">
                            <img width="50" height="50" src="">
                        <div class="frame"></div>                    	
                    </div>
                </td>
            </tr>
            <tr><td style="height:10px;"></td></tr>
            <tr>
                    <td valign="top" align="center" colspan="3">
                        <div class="font-username"><span></span</div>
                </td>
            </tr>
            <!--<tr>
                <td valign="top" align="center" colspan="3">
                    <div class="font-country">United States</div>
                </td>
            </tr>-->
            <tr><td style="height:25px;"></td></tr>
            <tr>
                    <td valign="top" align="left">
                    <div id="callacceptbutton" class="btnbg">
                            <input type="button" name="vedioonnoff" class="btn-on-off" value="Accept" style="padding-right:0px;padding-bottom:0px;padding-left: 40px;padding-top:0px;"/>
                    </div>
                </td>
                <td><div style="width:20px;"></div></td>
                <td valign="top" align="left">
                    <div id="rejectcallbutton" class="btnbg-cancel">
                            <input type="button" name="vedioonnoff" class="btn-cancel" value="Reject" style="padding-right:0px;padding-bottom:0px;padding-left: 22px;padding-top:0px;background-color: #6d6e70;">
                    </div>
                </td>
            </tr>
        </tbody></table>                	
    </div>
</div>
</body></html>
<div id="popupmodel"></div>
<div id="loader" align="center">
        <img src="<?php echo THEME_DIR . '/images/loader.png';?>" height="32" width="110" border="0"/>
</div>