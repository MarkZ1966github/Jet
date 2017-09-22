<?
    /*-----START -- Connect to Contegix to delete files on FTP to server-----*/
    
    $connection = ssh2_connect('199.193.197.27', 22);

    if (ssh2_auth_password($connection, 'gdstl-admin', '2M58#u3yXT-')) {
  echo "Authentication Successful!\n";
} else {
  die('Authentication Failed...');
}
    $sftp = ssh2_sftp($connection);
    
    ssh2_sftp_unlink($sftp, '/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/tracking/');
    echo "Files on Contegix FTP server removed";
    /*-----END -- Connect to Contegix to delete files on FTP to server-----*/
 ?>