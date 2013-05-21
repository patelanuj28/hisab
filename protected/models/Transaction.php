<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property string $id
 * @property string $bank_name
 * @property string $tran_date
 * @property string $description
 * @property string $address
 * @property double $amount
 *
 * The followings are the available model relations:
 * @property Individual[] $individuals
 */
class Transaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Transaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('amount', 'numerical'),
			array('id', 'length', 'max'=>11),
			array('bank_name', 'length', 'max'=>100),
			array('tran_date, description, address', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bank_name, tran_date, description, address, amount', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'individuals' => array(self::HAS_MANY, 'Individual', 'transaction_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bank_name' => 'Bank Name',
			'tran_date' => 'Tran Date',
			'description' => 'Description',
			'address' => 'Address',
			'amount' => 'Amount',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('tran_date',$this->tran_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('amount',$this->amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
