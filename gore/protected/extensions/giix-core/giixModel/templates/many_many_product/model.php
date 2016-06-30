<?php
/**
 * This is the template for generating the model class of a specified table.
 * In addition to the default model Code, this adds the CSaveRelationsBehavior
 * to the model class definition.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 * - $representingColumn: the name of the representing column for the table (string) or
 *   the names of the representing columns (array)
 */
?>
<?php echo "<?php\n"; ?>
/**
* MANY_MANY  Ajax Crud Admnistration
* <?php echo $modelClass; ?> Model
* InfoWebSphere {@link http://libkal.gr/infowebsphere}
* @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.0
 * @license The MIT License
 */

Yii::import('<?php echo "{$this->baseModelPath}.{$this->baseModelClass}"; ?>');

class <?php echo $modelClass; ?> extends <?php echo $this->baseModelClass . "\n"; ?>
{

    //paging size for all products
     const PAGING_SIZE_ALL=10;
    public $<?php echo  $this->class2var($modelClass);?>_image;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

        public function rules() {
		return array(
 array('<?php echo $this->class2var($this->modelClass);?>_image', 'file', 'types' => 'png, gif, jpg', 'allowEmpty' => true),
<?php foreach ($rules as $rule): ?>
<?php echo $rule . ",\n"; ?>
<?php endforeach; ?>
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
		);
	}

      public function searchCriteria(){

    $criteria = new CDbCriteria;
<?php foreach ($columns as $name => $column): ?>
<?php $partial = ($column->type === 'string' and !$column->isForeignKey); ?>
$criteria->compare('t.<?php echo $name; ?>', $this-><?php echo $name; ?><?php echo $partial ? ', true' : ''; ?>);
<?php endforeach; ?>
		
return $criteria;
    }

        	public function search() {
		$criteria = new CDbCriteria;

<?php foreach ($columns as $name => $column): ?>
<?php $partial = ($column->type === 'string' and !$column->isForeignKey); ?>
$criteria->compare('<?php echo $name; ?>', $this-><?php echo $name; ?><?php echo $partial ? ', true' : ''; ?>);
<?php endforeach; ?>

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
          'pagination' => array(
                                                             'pageSize' => self::PAGING_SIZE_ALL,
                                                              )
		));
	}


  	public function behaviors() {
		return array(
			'<?php echo  $this->class2var($modelClass);?>ImgBehavior' => array(
				'class' => 'ImageARBehavior',
				'attribute' => '<?php echo $this->class2var($this->modelClass);?>_image', // this must exist
				'extension' => 'png, gif, jpg', // possible extensions, comma separated
				'prefix' => 'img_',
				'relativeWebRootFolder' => 'img/product', // this folder must exist

				# 'forceExt' => png, // this is the default, every saved image will be a png one.
				# Set to null if you want to keep the original format

			//	'useImageMagick' => '/usr/bin', # I want to use imagemagick instead of GD, and
				# it is located in /usr/bin on my computer.

				// this will define formats for the image.
				// The format 'normal' always exist. This is the default format, by default no
				// suffix or no processing is enabled.
				'formats' => array(
					// create a thumbnail grayscale format
					'thumb' => array(
						'suffix' => '_thumb',
						'process' => array('resize' => array(100, 100)),
					),
                    	'small' => array(
						'suffix' => '_small',
						'process' => array('resize' => array(50,50)),
					),
				
					// create a large one (in fact, no resize is applied)
					'large' => array(
						'suffix' => '_large',
					),
					// and override the default :
					'normal' => array(
						'process' => array('resize' => array(200, 200)),
					),
				),

				'defaultName' => 'default', // when no file is associated, this one is used by getFileUrl
				// defaultName need to exist in the relativeWebRootFolder path, and prefixed by prefix,
				// and with one of the possible extensions. if multiple formats are used, a default file must exist
				// for each format. Name is constructed like this :
				//     {prefix}{name of the default file}{suffix}{one of the extension}
			)
		);
	}

}