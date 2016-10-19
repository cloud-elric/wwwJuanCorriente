<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_capitulos".
 *
 * @property string $id_capitulo
 * @property string $id_historia
 * @property string $txt_nombre
 * @property string $txt_imagen
 * @property string $txt_token
 * @property string $fch_creacion
 * @property string $fch_publicacion
 * @property string $b_habilitado
 *
 * @property EntHistorias $idHistoria
 * @property EntElementos[] $entElementos
 */
class EntCapitulos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_capitulos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_historia', 'txt_nombre', 'txt_imagen', 'txt_token'], 'required'],
            [['id_historia', 'b_habilitado'], 'integer'],
            [['fch_creacion', 'fch_publicacion'], 'safe'],
            [['txt_nombre', 'txt_imagen'], 'string', 'max' => 200],
            [['txt_token'], 'string', 'max' => 60],
            [['id_historia'], 'exist', 'skipOnError' => true, 'targetClass' => EntHistorias::className(), 'targetAttribute' => ['id_historia' => 'id_historia']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_capitulo' => 'Id Capitulo',
            'id_historia' => 'Id Historia',
            'txt_nombre' => 'Txt Nombre',
            'txt_imagen' => 'Txt Imagen',
            'txt_token' => 'Txt Token',
            'fch_creacion' => 'Fch Creacion',
            'fch_publicacion' => 'Fch Publicacion',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHistoria()
    {
        return $this->hasOne(EntHistorias::className(), ['id_historia' => 'id_historia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntElementos()
    {
        return $this->hasMany(EntElementos::className(), ['id_capitulo' => 'id_capitulo']);
    }
}
