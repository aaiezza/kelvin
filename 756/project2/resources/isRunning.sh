#!/bin/sh

PID_FILE=/home/axa9070/Sites/756/project2/resources/MyService-pid

if [ -e "$PID_FILE" ] && [ -d "/proc/`head -n 1 $PID_FILE`" ];
then
    out=$( lsof -Pi | grep "`head -n 1 $PID_FILE`" | grep "\*:" | awk '{ print $9 }' )
    out=$( echo $out | sed 's/\*://' )

    echo $out
else
    echo 0
fi

