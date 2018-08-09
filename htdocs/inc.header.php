<?php
/**************************************************
* VARIABLES
* No changes required if you stuck to the
* INSTALL-stretch.md instructions.
* If you want to change the paths, edit config.php
***************************************************/

/*
* DEBUGGING
* for debugging, set following var to true.
* This will only print the executable strings, not execute them
*/
$debug = "false"; // true or false

/* NO CHANGES BENEATH THIS LINE ***********/
/*
* Configuration file
* Due to an initial commit with the config file 'config.php' and NOT 'config.php.sample'
* we need to check first if the config file exists (it might get erased by 'git pull').
* If it does not exist:
* a) copy sample file to config.php and give warning
* b) if sample file does not exist: throw error and die
*/
if(!file_exists("config.php")) {
    if(!file_exists("config.php.sample")) {
        // no config nor sample config found. die.
        print "<h1>Configuration file not found</h1>
            <p>The files 'config.php' and 'config.php.sample' were not found in the
            directory 'htdocs'. Please download 'htdocs/config.php.sample' from the 
            <a href='https://github.com/MiczFlor/RPi-Jukebox-RFID/'>online repository</a>,
            copy it locally to 'htdocs/config.php' and then adjust it to fit your system.</p>";
        die;
    } else {
        // no config but sample config found: make copy (and give warning)
        if(!(copy("config.php.sample", "config.php"))) {
            // sample config can not be copied. die.
            print "<h1>Configuration file could not be created</h1>
                <p>The file 'config.php' was not found in the
                directory 'htdocs'. Attempting to create this file from 'config.php.sample'
                resulted in an error. </p>
                <p>
                Are the folder settings correct? You could try to run the following commands
                inside the folder 'RPi-Jukebox-RFID' and then reload the page:<br/>
                <pre>
sudo chmod -R 775 htdocs/
sudo chgrp -R www-data htdocs/
                </pre>
                </p>
                Alternatively, download 'htdocs/config.php.sample' from the 
                <a href='https://github.com/MiczFlor/RPi-Jukebox-RFID/'>online repository</a>,
                copy it locally to 'htdocs/config.php' and then adjust it to fit your system.</p>";
            die;
        } else {
            $warning = "<h4>Configuration file created</h4>
                <p>The file 'config.php' was not found in the
                directory 'htdocs'. A copy of the sample file 'config.php.sample' was made automatically.
                If you encounter any errors, edit the newly created 'config.php'.
                </p>
            ";
        }
    }
}
include("config.php");

$conf['url_abs']    = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; // URL to PHP_SELF

include("func.php");

// path to script folder from github repo on RPi
$conf['scripts_abs'] = realpath(getcwd().'/../scripts/');

/*******************************************
* URLPARAMETERS
*******************************************/

$urlparams = array();
/*
* Firstly, collect via 'GET', later collect 'POST'
*/
if(isset($_GET['play']) && trim($_GET['play']) != "") {
    $urlparams['play'] = trim($_GET['play']);
}

if(isset($_GET['playpos']) && trim($_GET['playpos']) != "") {
    $urlparams['playpos'] = trim($_GET['playpos']);
}

if(isset($_GET['player']) && trim($_GET['player']) != "") {
    $urlparams['player'] = trim($_GET['player']);
}

if(isset($_GET['stop']) && trim($_GET['stop']) != "") {
    $urlparams['stop'] = trim($_GET['stop']);
}

if(isset($_GET['volume']) && trim($_GET['volume']) != "") {
    $urlparams['volume'] = trim($_GET['volume']);
}

if(isset($_GET['maxvolume']) && trim($_GET['maxvolume']) != "") {
    $urlparams['maxvolume'] = trim($_GET['maxvolume']);
}

if(isset($_GET['volstep']) && trim($_GET['volstep']) != "") {
    $urlparams['volstep'] = trim($_GET['volstep']);
}

if(isset($_GET['mute']) && trim($_GET['mute']) == "true") {
    $urlparams['mute'] = trim($_GET['mute']);
}

if(isset($_GET['volumeup']) && trim($_GET['volumeup']) == "true") {
    $urlparams['volumeup'] = trim($_GET['volumeup']);
}

if(isset($_GET['volumedown']) && trim($_GET['volumedown']) == "true") {
    $urlparams['volumedown'] = trim($_GET['volumedown']);
}

if(isset($_GET['shutdown']) && trim($_GET['shutdown']) != "") {
    $urlparams['shutdown'] = trim($_GET['shutdown']);
}

if(isset($_GET['reboot']) && trim($_GET['reboot']) != "") {
    $urlparams['reboot'] = trim($_GET['reboot']);
}

if(isset($_GET['idletime']) && trim($_GET['idletime']) != "") {
    $urlparams['idletime'] = trim($_GET['idletime']);
}

if(isset($_GET['shutdownafter']) && trim($_GET['shutdownafter']) != "") {
    $urlparams['shutdownafter'] = trim($_GET['shutdownafter']);
}

if(isset($_GET['rfidstatus']) && trim($_GET['rfidstatus']) == "turnon") {
    $urlparams['rfidstatus'] = trim($_GET['rfidstatus']);
}

if(isset($_GET['rfidstatus']) && trim($_GET['rfidstatus']) == "turnoff") {
    $urlparams['rfidstatus'] = trim($_GET['rfidstatus']);
}

if(isset($_GET['gpiostatus']) && trim($_GET['gpiostatus']) == "turnon") {
    $urlparams['gpiostatus'] = trim($_GET['gpiostatus']);
}

if(isset($_GET['gpiostatus']) && trim($_GET['gpiostatus']) == "turnoff") {
    $urlparams['gpiostatus'] = trim($_GET['gpiostatus']);
}

if(isset($_GET['enableresume']) && trim($_GET['enableresume']) != "") {
    $urlparams['enableresume'] = trim($_GET['enableresume']);
}

if(isset($_GET['disableresume']) && trim($_GET['disableresume']) != "") {
    $urlparams['disableresume'] = trim($_GET['disableresume']);
}
/*
* Now check for $_POST
*/
if(isset($_POST['play']) && trim($_POST['play']) != "") {
    $urlparams['play'] = trim($_POST['play']);
}

if(isset($_POST['playpos']) && trim($_POST['playpos']) != "") {
    $urlparams['playpos'] = trim($_POST['playpos']);
}

if(isset($_POST['player']) && trim($_POST['player']) != "") {
    $urlparams['player'] = trim($_POST['player']);
}

if(isset($_POST['stop']) && trim($_POST['stop']) != "") {
    $urlparams['stop'] = trim($_POST['stop']);
}

if(isset($_POST['volume']) && trim($_POST['volume']) != "") {
    $urlparams['volume'] = trim($_POST['volume']);
}

if(isset($_POST['maxvolume']) && trim($_POST['maxvolume']) != "") {
    $urlparams['maxvolume'] = trim($_POST['maxvolume']);
}

if(isset($_POST['volstep']) && trim($_POST['volstep']) != "") {
    $urlparams['volstep'] = trim($_POST['volstep']);
}

if(isset($_POST['mute']) && trim($_POST['mute']) == "true") {
    $urlparams['mute'] = trim($_POST['mute']);
}

if(isset($_POST['volumeup']) && trim($_POST['volumeup']) == "true") {
    $urlparams['volumeup'] = trim($_POST['volumeup']);
}

if(isset($_POST['volumedown']) && trim($_POST['volumedown']) == "true") {
    $urlparams['volumedown'] = trim($_POST['volumedown']);
}

if(isset($_POST['shutdown']) && trim($_POST['shutdown']) != "") {
    $urlparams['shutdown'] = trim($_POST['shutdown']);
}

if(isset($_POST['reboot']) && trim($_POST['reboot']) != "") {
    $urlparams['reboot'] = trim($_POST['reboot']);
}

if(isset($_POST['idletime']) && trim($_POST['idletime']) != "") {
    $urlparams['idletime'] = trim($_POST['idletime']);
}

if(isset($_POST['shutdownafter']) && trim($_POST['shutdownafter']) != "") {
    $urlparams['shutdownafter'] = trim($_POST['shutdownafter']);
}

if(isset($_POST['rfidstatus']) && trim($_POST['rfidstatus']) == "turnon") {
    $urlparams['rfidstatus'] = trim($_POST['rfidstatus']);
}

if(isset($_POST['rfidstatus']) && trim($_POST['rfidstatus']) == "turnoff") {
    $urlparams['rfidstatus'] = trim($_POST['rfidstatus']);
}

if(isset($_POST['gpiostatus']) && trim($_POST['gpiostatus']) == "turnon") {
    $urlparams['gpiostatus'] = trim($_POST['gpiostatus']);
}

if(isset($_POST['gpiostatus']) && trim($_POST['gpiostatus']) == "turnoff") {
    $urlparams['gpiostatus'] = trim($_POST['gpiostatus']);
}

if(isset($_POST['enableresume']) && trim($_POST['enableresume']) != "") {
    $urlparams['enableresume'] = trim($_POST['enableresume']);
}

if(isset($_POST['disableresume']) && trim($_POST['disableresume']) != "") {
    $urlparams['disableresume'] = trim($_POST['disableresume']);
}
/*******************************************
* ACTIONS
*******************************************/

// if debug, do nothing but print everything
if($debug == "true") { 
    print "\$conf: <pre>\n"; print_r($conf); print "</pre>";
    print "\$urlparams: <pre>\n"; print_r($urlparams); print "</pre>";
}

// change volume
if(isset($urlparams['volume'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=setvolume -v=".$urlparams['volume'];
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// change max volume
if(isset($urlparams['maxvolume'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=setmaxvolume -v=".$urlparams['maxvolume'];
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// change volume step
if(isset($urlparams['volstep'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=setvolstep -v=".$urlparams['volstep'];
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}


// volume mute (toggle)
if(isset($urlparams['mute'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=mute";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// volume up
if(isset($urlparams['volumeup'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=volumeup";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// volume down
if(isset($urlparams['volumedown'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=volumedown";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// reboot the jukebox
if(isset($urlparams['reboot']) && $urlparams['reboot'] == "true") {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=reboot > /dev/null 2>&1 &";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// shutdown the jukebox
if(isset($urlparams['shutdown']) && $urlparams['shutdown'] == "true") {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=shutdown > /dev/null 2>&1 &";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// set idletime
if(isset($urlparams['idletime'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=setidletime -v=".$urlparams['idletime'];
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// set shutdownafter time (sleeptimer)
if(isset($urlparams['shutdownafter'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=shutdownafter -v=".$urlparams['shutdownafter'];
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// start the rfid service
if(isset($urlparams['rfidstatus']) && $urlparams['rfidstatus'] == "turnon") {
    $exec = "/usr/bin/sudo /bin/systemctl start rfid-reader.service";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// stop the rfid service
if(isset($urlparams['rfidstatus']) && $urlparams['rfidstatus'] == "turnoff") {
    $exec = "/usr/bin/sudo /bin/systemctl stop rfid-reader.service";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// start the gpio button service
if(isset($urlparams['gpiostatus']) && $urlparams['gpiostatus'] == "turnon") {
    $exec = "/usr/bin/sudo /bin/systemctl start gpio-buttons.service";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// stop the gpio button service
if(isset($urlparams['gpiostatus']) && $urlparams['gpiostatus'] == "turnoff") {
    $exec = "/usr/bin/sudo /bin/systemctl stop gpio-buttons.service";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// enable resume
if(isset($urlparams['enableresume']) && $urlparams['enableresume'] != "" && is_dir(urldecode($urlparams['enableresume']))) {
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
    // pass folder to resume script
    // escape whitespaces with backslashes
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/resume_play.sh -c=enableresume -v=".preg_replace('/\s+/', '\ ',basename($urlparams['enableresume']));
    exec($exec);

    /* redirect to drop all the url parameters */
    header("Location: ".$conf['url_abs']);
    exit; 
    }
}

// disable resume
if(isset($urlparams['disableresume']) && $urlparams['disableresume'] != "" && is_dir(urldecode($urlparams['disableresume']))) {
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
    // pass folder to resume script
    // escape whitespaces with backslashes
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/resume_play.sh -c=disableresume -v=".preg_replace('/\s+/', '\ ',basename($urlparams['disableresume']));
    exec($exec);

    /* redirect to drop all the url parameters */
    header("Location: ".$conf['url_abs']);
    exit; 
    }
}

// stop playing
if(isset($urlparams['stop']) && $urlparams['stop'] == "true") {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerstop";
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}

// play folder audio files
if(isset($urlparams['play']) && $urlparams['play'] != "" && is_dir(urldecode($urlparams['play']))) {
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
    // pass folder to playout script
    // escape whitespaces with backslashes
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/rfid_trigger_play.sh -d=".preg_replace('/\s+/', '\ ',basename($urlparams['play']));//basename($urlparams['play']);
    exec($exec);

    /* redirect to drop all the url parameters */
    header("Location: ".$conf['url_abs']);
    exit; 
    }
}

// play from playlist position
if(isset($urlparams['playpos'])) {
    $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerplay -v=".$urlparams['playpos'];
    if($debug == "true") { 
        print "Command: ".$exec; 
    } else { 
        exec($exec);
        /* redirect to drop all the url parameters */
        header("Location: ".$conf['url_abs']);
        exit; 
    }
}


// control player through web interface
if(isset($urlparams['player'])) {
    if($urlparams['player'] == "next") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playernext";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
    if($urlparams['player'] == "prev") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerprev";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
    if($urlparams['player'] == "play") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerplay";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
    if($urlparams['player'] == "replay") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerreplay";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
    if($urlparams['player'] == "pause") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerpause";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
    if($urlparams['player'] == "repeat") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerrepeat -v=playlist";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
    if($urlparams['player'] == "single") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerrepeat -v=single";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
    if($urlparams['player'] == "repeatoff") {
        $exec = "/usr/bin/sudo ".$conf['scripts_abs']."/playout_controls.sh -c=playerrepeat -v=off";
        if($debug == "true") { 
            print "Command: ".$exec; 
        } else { 
            exec($exec);
            /* redirect to drop all the url parameters */
            header("Location: ".$conf['url_abs']);
            exit; 
        }
    }
}
?>
