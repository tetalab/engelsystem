<?php

/**
 * Creates a log entry.
 * @param $nick Username
 * @param $message Log Message
 */
function LogEntry_create($nick, $message) {
  $timestamp = time();

  sql_query("INSERT INTO `LogEntries` SET `timestamp`=" . sql_escape($timestamp) . ", `nick`='" . sql_escape($nick) . "', `message`='" . sql_escape($message) . "'");
}

/**
 * Returns log entries of the last 24 hours with maximum count of 1000.
 */
function LogEntries() {
  $log_entries_source = sql_select("SELECT * FROM `LogEntries` WHERE `timestamp` > " . (time() - 24*60*60) . " ORDER BY `timestamp` DESC LIMIT 1000");
  return $log_entries_source;
}


?>