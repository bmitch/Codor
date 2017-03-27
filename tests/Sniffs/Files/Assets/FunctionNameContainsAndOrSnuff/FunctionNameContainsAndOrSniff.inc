<?php

// This looks like it has the word
// "and" but it's part of another word
function expand()
{

}

// This looks like it has the word
// "or" but it's part of another word
function orbit()
{

}

// This looks like it has the word
// "or" but it's part of another word
function getOrder()
{

}

// This looks like it has the word
// "or" but it's part of another word
function get_order()
{

}

// This contains a forbidden word
// after an allowed word
function get_order_or_abort()
{
	// Fail
}

// This contains a forbidden word
// prior to an allowed word
function get_refund_or_order()
{
	// Fail
}
// This contains a forbidden word
// after an allowed word
function getOrderOrAbort()
{
	// Fail
}

// This contains a forbidden word
// prior to an allowed word
function getRefundOrOrder()
{
	// Fail
}

function thisDoesThisAndThat($foo)
{
	// Fail

	return "This and that";
}

function thisDoesThisOrThat($foo)
{
	// Fail

	return "This or that";
}

function this_and_that()
{
	// Fail
}

function that_And_This()
{
	// Fail
}

function this_or_that()
{
	// Fail
}

function that_Or_This()
{
	// Fail
}