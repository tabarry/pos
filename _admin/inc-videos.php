<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$max_videos = 5;
$videoWidth = '480';
$videoHeight = '270';
$do = suSegment(1);
suFrameBuster(ADMIN_URL . 'videos.php');

function suParse($str, $start, $end) {
    $str1 = explode($start, $str);
    $str1[1];
    $str2 = explode($end, $str1[1]);
    return $str2[0];
}

if ($do == 'add') {
    //Clear previos table
    $sql = "UPDATE sulata_videos SET video__dbState='Deleted'";
    suQuery($sql);
    //Add new records
    for ($i = 0; $i <= sizeof($_POST['video__Code']) - 1; $i++) {
        if ($_POST['video__Code'][$i] != '') {
            $videoCode = $_POST['video__Code'][$i];
            $videoCode = str_replace("'", '"', $videoCode);
            $w = suParse($videoCode, 'width="', '"');
            $videoCode = str_replace('width="' . $w . '"', 'width="' . $videoWidth . '"', $videoCode);
            $h = suParse($videoCode, 'height="', '"');
            $videoCode = str_replace('height="' . $h . '"', 'height="' . $videoHeight . '"', $videoCode);
            $sequence = ($i * 10);
            $sql = "INSERT INTO sulata_videos SET video__Title='" . suStrip($_POST['video__Title'][$i]) . "',video__Code='" . suStrip($videoCode) . "',video__Sequence='$sequence',video__Last_Action_On ='" . date('Y-m-d H:i:s') . "',video__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "',video__dbState='Live'";
            suQuery($sql);
        }
    }
    suPrintJS("parent.window.location.href='" . ADMIN_URL . "videos.php?msg=$max_videos'");
    exit;
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $getSettings['site_name'] . ' | ' . $getSettings['site_tagline']; ?></title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }

            table {
                font-size: 1em;
            }

            .ui-draggable, .ui-droppable {
                background-position: top;
            }

            #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
            #sortable li { margin: 3 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 28px; }
            #sortable li span { position: absolute; margin-left: -1.3em; margin-top: 1;cursor: pointer }

            .txtBox{
                width:95%;
                padding: 2px;
                border:1px solid #ccc;
                height: 20px;
                line-height: 20px;
            }
            .btn.btn-black {
                background: #666666 none repeat scroll 0 0;
                color: #ffffff;
            }
            .btn {
                border-radius: 2px;
                outline: medium none !important;
                text-decoration: none !important;
            }
            .btn {
                -moz-user-select: none;
                background-image: none;
                border: 1px solid transparent;
                border-radius: 3px;
                cursor: pointer;
                display: inline-block;
                font-size: 13px;
                font-weight: normal;
                line-height: 1.42857;
                margin-bottom: 0;
                padding: 6px 12px;
                text-align: center;
                vertical-align: middle;
                white-space: nowrap;
            }
            .btn:hover{
                background-color: #333;
                color: #ffffff;
            }
            a{
                color:crimson !important;
                font-size: 11px;
                text-decoration: underline !important;
            }

        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script>
            $(function() {
                $("#sortable").sortable();
                //$("#sortable").disableSelection();
            });
        </script>
    </head>
    <body>
        <form name="suForm" id="suForm" action="<?php echo ADMIN_URL; ?>inc-videos.php/add/"  method="post" target="remote">
            <ul id="sortable">
                <?php
//Get already added video count
                $sql = "SELECT video__Title,video__Code FROM sulata_videos WHERE video__dbState='Live' ORDER BY video__Sequence";
                $result = suQuery($sql);
                while ($row = suFetch($result)) {
                    if (suNumRows($result) > 0) {
                        ?>
                        <li id="li_<?php echo $sr = $sr + 1; ?>"><span class="ui-icon ui-icon-arrow-4"></span> 
                            <table class="ui-state-default" width="100%" >
                                <tr>
                                    <td width="45%">
                                        <input type="text" name="video__Title[]" class="txtBox" placeholder="Title" value="<?php echo suUnstrip($row['video__Title']); ?>"/>
                                    </td>
                                    <td width="45%">
                                        <input type="text" name="video__Code[]" class="txtBox" placeholder="Code" value="<?php echo suUnstrip($row['video__Code']); ?>"/>
                                    </td>
                                    <td width="10%" align="center">
                                        <a href="javascript:;" onclick="$('#li_<?php echo $sr; ?>').remove();"><i class="ui-icon ui-icon-trash" style="color:crimson !important;"></i></a>

                                    </td>
                                </tr>
                            </table>
                        </li>
                        <?php
                    }
                }suFree($result);
                ?>
                <?php for ($i = 1; $i <= $max_videos; $i++) { ?>
                    <li id="li_<?php echo $sr = $sr + 1; ?>"><span class="ui-icon ui-icon-arrow-4"></span> 
                        <table class="ui-state-default" width="100%" >
                            <tr>
                                <td width="45%">
                                    <input autocomplete="off" type="text" name="video__Title[]" class="txtBox" placeholder="Title"/>
                                </td>
                                <td width="45%">
                                    <input autocomplete="off" type="text" name="video__Code[]" class="txtBox" placeholder="Code"/>
                                </td>
                                <td width="10%">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </li>
                <?php }
                ?>
                <li style="text-align:right">
                    <input type="submit" name="submit" value="Submit" class="btn btn-black"/>
                </li>
            </ul>


        </form>

    </body>
</html>