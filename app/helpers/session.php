<?php

function welcome($index) 
{
	if (isset($_SESSION[$index])) {
		$user = $_SESSION[$index];

		return "{$user->login} | <a href='/login/destroy'>Logout</a>";
	}
}
