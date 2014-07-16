<?php
/**
 * BlogFixture
 *
 */
class BlogFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '53c69fd8-5840-45d9-add0-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-c6cc-44ec-a83b-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-1b90-4252-9a91-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-6adc-46cb-ac90-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-bb54-4d8b-8f24-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-0334-4f2f-a0a1-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-4920-46f7-9d32-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-92f4-43e8-b746-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-da70-43c6-81a4-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
		array(
			'id' => '53c69fd8-2124-467a-8c42-7cb374524da5',
			'title' => 'Lorem ipsum dolor sit amet',
			'text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_published' => 1,
			'created' => '2014-07-16 15:52:56',
			'modified' => '2014-07-16 15:52:56'
		),
	);

}
