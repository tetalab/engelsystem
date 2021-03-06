<?php
function admin_arrive() {
  $msg = "";
  $search = "";
  if (isset ($_REQUEST['search']))
    $search = strip_request_item('search');

  if (isset ($_REQUEST['reset']) && preg_match("/^[0-9]*$/", $_REQUEST['reset'])) {
    $id = $_REQUEST['reset'];
    $user_source = User($id);
    if($user_source != null) {
      sql_query("UPDATE `User` SET `Gekommen`=0 WHERE `UID`=" . sql_escape($id) . " LIMIT 1");
      engelsystem_log("User set to not arrived: " . User_Nick_render($user_source));
      $msg = success("Reset done. Angel has not arrived.", true);
    } else $msg = error("Angel not found.", true);
  }
  elseif (isset ($_REQUEST['arrived']) && preg_match("/^[0-9]*$/", $_REQUEST['arrived'])) {
    $id = $_REQUEST['arrived'];
    $user_source = User($id);
    if($user_source != null) {
      sql_query("UPDATE `User` SET `Gekommen`=1 WHERE `UID`=" . sql_escape($id) . " LIMIT 1");
      engelsystem_log("User set has arrived: " . User_Nick_render($user_source));
      $msg = success("Angel has been marked as arrived.", true);
    } else $msg = error("Angel not found.", true);
  }

  $users = sql_select("SELECT * FROM `User` ORDER BY `Nick`");
  $table = "";
  if ($search == "")
    $tokens = array ();
  else
    $tokens = explode(" ", $search);
  foreach ($users as $usr) {
    if (count($tokens) > 0) {
      $match = false;
      $index = join("", $usr);
      foreach ($tokens as $t)
        if (stristr($index, trim($t))) {
        $match = true;
        break;
      }
      if (!$match)
        continue;
    }
    $table .= '<tr>';
    $table .= '<td>' . User_Nick_render($usr) . '</td>';
    if ($usr['Gekommen'] == 1)
      $table .= '<td>yes</td><td><a href="' . page_link_to('admin_arrive') . '&reset=' . $usr['UID'] . '&search=' . $search . '">reset</a></td>';
    else
      $table .= '<td></td><td><a href="' . page_link_to('admin_arrive') . '&arrived=' . $usr['UID'] . '&search=' . $search . '">arrived</a></td>';
    $table .= '</tr>';
  }
  return template_render('../templates/admin_arrive.html', array (
    'search' => $search,
    'table' => $table,
    'msg' => $msg,
    'link' => page_link_to('admin_arrive')
  ));
}
?>
