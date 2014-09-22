var timzonelistarr= new Array();
    timzonelistarr['GMT-12:00']="(GMT -12:00) Eniwetok, Kwajalein";
    timzonelistarr['GMT-11:00']="(GMT -11:00) Midway Island, Samoa";
    timzonelistarr['GMT-10:00']="(GMT -10:00) Hawaii";
    timzonelistarr['GMT-09:00']="(GMT -9:00) Alaska";
    timzonelistarr['GMT-08:00']="(GMT -8:00) Pacific Time (US & Canada)";
    timzonelistarr['GMT-07:00']="(GMT -7:00) Mountain Time (US & Canada)";
    timzonelistarr['GMT-06:00']="(GMT -6:00) Central Time (US & Canada), Mexico City";
    timzonelistarr['GMT-05:00']="(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima";
    timzonelistarr['GMT-04:00']="(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz";
    timzonelistarr['GMT-04:30']="(GMT -4:30) Caracas";
    timzonelistarr['GMT-03:30']="(GMT -3:30) Newfoundland";
    timzonelistarr['GMT-03:00']="(GMT -3:00) Brazil, Buenos Aires, Georgetown";
    timzonelistarr['GMT-02:00']="(GMT -2:00) Mid-Atlantic";
    timzonelistarr['GMT-01:00']="(GMT -1:00) Azores, Cape Verde Islands";
    timzonelistarr['GMT 00:00']="(GMT 0:00) Western Europe Time, London, Lisbon, Casablanca, Greenwich";
    timzonelistarr['GMT+01:00']="(GMT +1:00) Brussels, Copenhagen, Madrid, Paris";
    timzonelistarr['GMT+02:00']="(GMT +2:00) Kaliningrad, South Africa";
    timzonelistarr['GMT+03:00']="(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg";
    timzonelistarr['GMT+03:30']="(GMT +3:30) Tehran";
    timzonelistarr['GMT+04:00']="(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi";
    timzonelistarr['GMT+04:30']="(GMT +4:30) Kabul";
    timzonelistarr['GMT+05:00']="(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent";
    timzonelistarr['GMT+05:30']="(GMT +5:30) Mumbai, Kolkata, Chennai, New Delhi";
    timzonelistarr['GMT+05:45']="(GMT +5:45) Kathmandu";
    timzonelistarr['GMT+06:00']="(GMT +6:00) Almaty, Dhaka, Colombo";
    timzonelistarr['GMT+07:00']="(GMT +7:00) Bangkok, Hanoi, Jakarta";
    timzonelistarr['GMT+08:00']="(GMT +8:00) Beijing, Perth, Singapore, Hong Kong";
    timzonelistarr['GMT+09:00']="(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk";
    timzonelistarr['GMT+09:30']="(GMT +9:30) Adelaide, Darwin";
    timzonelistarr['GMT+10:00']="(GMT +10:00) Eastern Australia, Guam, Vladivostok";
    timzonelistarr['GMT+11:00']="(GMT +11:00) Magadan, Solomon Islands, New Caledonia";
    timzonelistarr['GMT+12:00']="(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka";
    timzonelistarr['GMT+13:00']="(GMT +13:00) Nuku'alofa";
    

String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    //if (seconds < 10) {seconds = "0"+seconds;}
    var time    = hours+':'+minutes;
    return time;
}

var d = new Date()
var timezoneoffset=d.getTimezoneOffset() * 60;
if(timezoneoffset>0){
    var operatorsign='-';
}
else if(timezoneoffset<0){
    var operatorsign='+';
    timezoneoffset=Math.abs(timezoneoffset);
}
else{
    var operatorsign=' ';
}
var timeszonestr=new String(timezoneoffset);
var localtimezone =(timzonelistarr['GMT'+operatorsign+timeszonestr.toHHMMSS()]);
jQuery(document).ready(function(){
    jQuery('#field_2364').val(localtimezone);
})