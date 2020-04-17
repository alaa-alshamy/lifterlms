<?php
/**
 * Tests for the LLMS_Abstract_Admin_Tool class
 *
 * @package LifterLMS/Tests/Abstracts
 *
 * @group abstracts
 * @group admin
 * @group admin_tools
 *
 * @since [version]
 */
class LLMS_Test_Abstract_Admin_Tool extends LLMS_UnitTestCase {

	/**
	 * Setup before class
	 *
	 * Include abstract class.
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public static function setUpBeforeClass() {

		parent::setUpBeforeClass();

		require_once LLMS_PLUGIN_DIR . 'includes/abstracts/llms-abstract-admin-tool.php';

	}

	/**
	 * Retrieve a mock for the abstract class.
	 *
	 * @since [version]
	 *
	 * @return LLMS_Abstract_Admin_Tool
	 */
	private function get_abstract_mock() {

		$mock = $this->getMockForAbstractClass( 'LLMS_Abstract_Admin_Tool' );
		LLMS_Unit_Test_Util::set_private_property( $mock, 'id', 'mock' );

		remove_filter( 'llms_status_tools', array( $mock, 'register' ) );
		remove_action( 'llms_status_tool', array( $mock, 'maybe_handle' ) );

		return $mock;

	}

	/**
	 * Retrieve a "concrete" mock with the abstract methods defined.
	 *
	 * @since [version]
	 *
	 * @param boolean $load The mock return of `should_load()`.
	 * @return LLMS_Abstract_Admin_Tool
	 */
	private function get_concrete_mock( $load = true, $handle = true ) {

		// Gross.
		global $llms_mock_temp_load;
		$llms_mock_temp_load = $load;

		$mock = new class extends LLMS_Abstract_Admin_Tool {
			protected $id = 'mock';
			public function should_load() {
				// Disgusting.
				global $llms_mock_temp_load;
				return $llms_mock_temp_load;
			}
			protected function handle() { return true; }
			protected function get_description() { return 'Description'; }
			protected function get_label() { return 'Label'; }
			protected function get_text() { return 'Text'; }
		};

		// Ehck.
		unset( $llms_mock_temp_load );

		return $mock;

	}

	/**
	 * Test the constructor when the tool should load.
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function test_constructor_should_load() {

		$tool = $this->get_abstract_mock();
		$tool->__construct();

		$this->assertEquals( 10, has_filter( 'llms_status_tools', array( $tool, 'register' ) ) );
		$this->assertEquals( 10, has_action( 'llms_status_tool', array( $tool, 'maybe_handle' ) ) );

	}

	/**
	 * Test maybe_handle()
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function test_maybe_handle() {

		$tool = $this->get_concrete_mock();

		$this->assertFalse( $tool->maybe_handle( 'fake' ) );
		$this->assertTrue( $tool->maybe_handle( 'mock' ) );

	}

	/**
	 * Test register() when the tool should load.
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function test_register() {

		$tool = $this->get_concrete_mock();
		$this->assertEquals( array(
			'mock' => array(
				'description' => 'Description',
				'label'       => 'Label',
				'text'        => 'Text',
			),
		), $tool->register( array() ) );

	}

	/**
	 * Test register() when the tool should not load.
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function test_register_no_load() {

		$tool = $this->get_concrete_mock( false );

		$this->assertEquals( array(), $tool->register( array() ) );

	}

	/**
	 * Test should_load() stub.
	 *
	 * @since [version]
	 *
	 * @return void
	 */
	public function test_should_load() {

		$tool = $this->get_abstract_mock();
		$this->assertTrue( LLMS_Unit_Test_Util::call_method( $tool, 'should_load' ) );

	}

}
