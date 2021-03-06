<?php
/**
 * Notification View: Quiz Failed
 *
 * @package LifterLMS/Notifications/Views/Classes
 *
 * @since 3.8.0
 * @version 3.24.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Notification View: Quiz Failed
 *
 * @since 3.8.0
 * @since 3.24.0 Unknown.
 */
class LLMS_Notification_View_Quiz_Failed extends LLMS_Abstract_Notification_View_Quiz_Completion {

	/**
	 * Notification Trigger ID
	 *
	 * @var string
	 */
	public $trigger_id = 'quiz_failed';

	/**
	 * Setup body content for output
	 *
	 * @return   string
	 * @since    3.8.0
	 * @version  3.24.0
	 */
	protected function set_body() {
		if ( 'email' === $this->notification->get( 'type' ) ) {
			return $this->set_body_email();
		}
		$content  = sprintf( __( 'You failed %s!', 'lifterlms' ), '{{QUIZ_TITLE}}' );
		$content .= "\r\n\r\n{{GRADE_BAR}}";
		return $content;
	}

	/**
	 * Setup notification icon for output
	 *
	 * @return   string
	 * @since    3.8.0
	 * @version  3.8.0
	 */
	protected function set_icon() {
		return $this->get_icon_default( 'negative' );
	}

	/**
	 * Setup notification subject for output
	 *
	 * @return   string
	 * @since    3.8.0
	 * @version  3.8.0
	 */
	protected function set_subject() {
		return sprintf( __( '%1$s failed %2$s', 'lifterlms' ), '{{STUDENT_NAME}}', '{{QUIZ_TITLE}}' );
	}

	/**
	 * Setup notification title for output
	 *
	 * @return   string
	 * @since    3.8.0
	 * @version  3.8.0
	 */
	protected function set_title() {
		return sprintf( __( '%s failed a quiz', 'lifterlms' ), '{{STUDENT_NAME}}' );
	}

}
