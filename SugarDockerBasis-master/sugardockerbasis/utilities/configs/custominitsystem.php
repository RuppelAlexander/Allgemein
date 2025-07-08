<?php
$set = [
    'admin_email'=> 'crmadmin@docker.local',
    'user_email' => 'iscuser@docker.local',
    'user_name'=>"iscuser",
    'user_first_name'=>'',
    'user_last_name'=>'ISCUser',
    'user_passwd'=>'init999',
    'User_Prefs'=>[
        'viewed_tour'=> 1,
        'datef' => 'd.m.Y',
        'timef' => 'H:i',
        'name-format' => 's f l',
        'appearance'=>'light',
        'export_delimiter'=>';',
        'num_grp_sep'=>'.',
        'dec_sep'=>',',
        'number_pinned_modules'=>8,
    ],
    'mail_smtpserver'=>'mailhog',
    'mail_smtpport'=>1025,
    'mail_smtpssl'=>0,
];

echo 'Updating admin user' . PHP_EOL;
$admin = \BeanFactory::newBean('Users');
$admin->getSystemUser();
$admin->email1 = $set['admin_email'];
$admin->cookie_consent = 1;
$admin->save();

$admin = \BeanFactory::getBean('Users', $admin->id);
SetUserPrefs($admin,$set['User_Prefs']);


$admin->savePreferencesToDB();

echo 'Creating  user' . $set['user_name'] .PHP_EOL;
$u = \BeanFactory::newBean('Users');
$u->user_name = $set['user_name'];
$u->first_name = $set['user_first_name'];
$u->last_name = $set['user_last_name'];
$u->user_hash = \User::getPasswordHash($set['user_passwd']);
$u->status = 'Active';
$u->email1 = $set['user_email'];
$u->cookie_consent = 1;
$u->save();

$u = \BeanFactory::getBean('Users', $u->id);
SetUserPrefs($u,$set['User_Prefs']);
$u->savePreferencesToDB();

echo 'Setting default mail server to '.$set['mail_smtpserver'] . PHP_EOL;
$oe = \BeanFactory::newBean('OutboundEmail');
$oe->mail_smtpserver = $set['mail_smtpserver'];
$oe->mail_smtpport = $set['mail_smtpport'];
$oe->mail_smtpssl = $set['mail_smtpssl'];
$oe->saveSystem();

$query = 'UPDATE `config` SET `value`=? WHERE `category`=? and `name`=?';
$conn = $GLOBALS['db']->getConnection(); 
$result = $conn->executeQuery($query, ['manual','Update','CheckUpdates']);

function SetUserPrefs($UserBean,$Prefs){
  foreach($Prefs as $Key=>$val){
            $UserBean->setPreference($Key,$val);
    }
}