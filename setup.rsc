//on login
/tool fetch url="http://situ.cybers-s.net/flatable_ci/mikrotik/hotspot_notif/wnhxcfstmw4xGuCHKuEtpBYrVT7bmiHxrBAmTVqf4MxUIrYbRWgpGi5yL0Ogq6hwqXwHxUeVcQqBrBrgtCj09w__.php?type=login&user=$user" keep-result=no;

/tool fetch url="http://situ.cybers-s.net/flatable_ci/mikrotik/session/wnhxcfstmw4xGuCHKuEtpBYrVT7bmiHxrBAmTVqf4MxUIrYbRWgpGi5yL0Ogq6hwqXwHxUeVcQqBrBrgtCj09w__" keep-result=no;


//on logout
:local bytesin
:local bytesout
:local uptime

/tool user-manager user
:foreach i in=[find username=$user] do={
:set $bytesin [get $i download-used]
:set $bytesout [get $i upload-used]
:set $uptime [get $i uptime-used]

}

/tool fetch url="http://situ.cybers-s.net/flatable_ci/mikrotik/hotspot_notif/wnhxcfstmw4xGuCHKuEtpBYrVT7bmiHxrBAmTVqf4MxUIrYbRWgpGi5yL0Ogq6hwqXwHxUeVcQqBrBrgtCj09w__.php?type=logout&user=$user&down=$bytesin&upload=$bytesout&uptime=$uptime" keep-result=no;

/tool fetch url="http://situ.cybers-s.net/flatable_ci/mikrotik/session/wnhxcfstmw4xGuCHKuEtpBYrVT7bmiHxrBAmTVqf4MxUIrYbRWgpGi5yL0Ogq6hwqXwHxUeVcQqBrBrgtCj09w__" keep-result=no;



