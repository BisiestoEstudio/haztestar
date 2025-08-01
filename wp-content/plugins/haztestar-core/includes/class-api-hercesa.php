<?php

namespace BIS_Core;



class Api_Hercesa {

	static function init() {
		add_filter('show_admin_bar', array(__CLASS__, 'show_admin_bar'));
	}




}

Api_Hercesa::init();