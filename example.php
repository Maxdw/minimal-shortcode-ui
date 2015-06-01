<?php
if(!class_exists('\Sui\Shortcodes')) {
	return;
}

use \Sui\Shortcodes as Shortcodes;
use \Sui\Shortcode as Shortcode;

// this will register the shortcode below into the factory
$result = Shortcodes::register('ExampleShortcodeTest');

if(!$result) {
	throw new Exception('Failed to register this example shortcode somehow..');
}

/**
 * This is an example shortcode.
 */
class ExampleShortcodeTest extends Shortcode {
	
	/**
	 * Will be prepended to the shortcode
	 * its tag name followed by an underscore.
	 *
	 * @var string
	 */
	protected $_tagNamePrefix = 'sui';
	
	/**
	 * The shortcode's description.
	 *
	 * @var string
	 */
	protected $_description = 'Shortcode description';
	
	/**
	 * Indicates whether this is an enclosing shortcode.
	 *
	 * @var boolean
	 */
	protected $_enclosed = true;
	
	/**
	 * Defines the shortcode attributes and default values.
	 *
	 * @var array
	 */
	protected $_attributes = array(
		'name' => '',
		'image_id' => '',
		'test' => false,
		'choose' => ''
	);
	
	/**
	 * Class constructor
	 */
	public function __construct() {
		parent::__construct();
		
		$this->_setSchemaAttribute('name', '', 'text');
		$this->_setSchemaAttribute('image_id', '', 'image');
		$this->_setSchemaAttribute('test', '', 'checkbox');
		$this->_setSchemaAttribute('choose', '', 'select', array(
			'options' => array(
				'' => 'Choose...',
				'1' => 'Something',
				'2' => 'Test'
			)
		));
	}
	
	/**
	 * Renders this shortcode.
	 *
	 * @param array $atts
	 * @param string|null $content
	 * @return string
	 */
	public function render($atts, $content = null) {
		$atts = shortcode_atts($this->_attributes, $atts);
		
		if(!$content) {
			$content = '';
		}
		
		?>
		<div>
			<h1><?php echo $atts['name'] ?></h1>
			
			<?php if($atts['image_id']): ?>
			<img src="<?php wp_get_attachment_image_src($atts['image_id'], 'full') ?>" alt="" />
			<?php endif; ?>
			
			<p><?php echo $atts['test'] ? 'enabled' : 'disabled' ?></p>
		</div>		
		<?php
		
		// if enclosement allow nested shortcodes
		if($this->_enclosed) {
			$content = do_shortcode($content);
		}
		
		return $content;
	}
	
}
?>