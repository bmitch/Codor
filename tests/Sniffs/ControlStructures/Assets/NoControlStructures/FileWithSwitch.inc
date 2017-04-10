<?php

class FooBar
{
    function alpha($one)
    {
        switch (true) {
           case "true":
                print 'true';
            break;

            case "false":
                print 'false';
                break;
        }

    }
}

function beta($one)
{
    switch (true) {
       case "true":
            print 'true';
        break;

        case "false":
            print 'false';
            break;
    }
}