<?php
abstract class toeWordpressWidgetPrt extends WP_Widget {
	public function preWidget($args, $instance) {
		if(framePrt::_()->isTplEditor())
			echo $args['before_widget'];
	}
	public function postWidget($args, $instance) {
		if(framePrt::_()->isTplEditor())
			echo $args['after_widget'];
	}
}
