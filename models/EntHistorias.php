<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_historias".
 *
 * @property string $id_historia
 * @property string $txt_token
 * @property string $txt_image
 * @property string $txt_descripcion
 * @property string $b_habilitado
 *
 * @property EntCapitulos[] $entCapitulos
 * @property EntElementos[] $entElementos
 */
class EntHistorias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_historias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_token', 'txt_descripcion','txt_nombre'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_image'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_historia' => 'Id Historia',
            'txt_token' => 'Txt Token',
            'txt_image' => 'Txt Image',
            'txt_descripcion' => 'Txt Descripcion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntCapitulos($nombre='')
    {
    	if(Yii::$app->user->isGuest){
        return $this->hasMany(EntCapitulos::className(), ['id_historia' => 'id_historia'])->where('fch_publicacion <=NOW() AND b_habilitado=1')->andFilterWhere(['like', 'txt_nombre', $nombre])->orderBy('fch_publicacion');
    	}else{
    		return $this->hasMany(EntCapitulos::className(), ['id_historia' => 'id_historia'])->where('b_habilitado=1')->andFilterWhere(['like', 'txt_nombre', $nombre])->orderBy('fch_publicacion');
    	}
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntElementos()
    {
        return $this->hasMany(EntElementos::className(), ['id_historia' => 'id_historia']);
    }
}
