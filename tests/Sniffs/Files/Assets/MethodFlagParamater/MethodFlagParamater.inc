<?php
function alpha($one)
{
    //pass
}

function beta($one = true)
{
    //fail
}

function charlie($one = false)
{
    //fail
}

function delta($one = false, $two = false)
{
    //fail X 2
}

function echo($one=true)
{
    //fail
}

function foxtrot($one=false)
{
    //fail
}

function golf($one, $two, $tree)
{
    //pass
}

class Foobar
{
    function alpha($one)
    {
        //pass
    }

    function beta($one = true)
    {
        //fail
    }
    
    function charlie($one = false)
    {
        //fail
    }

    function delta($one = false, $two = false)
    {
        //fail X 2
    }

    function echo($one=true)
    {
        //fail
    }

    function foxtrot($one=false)
    {
        //fail
    }

    function golf($one, $two, $tree)
    {
        //pass
    }
}

