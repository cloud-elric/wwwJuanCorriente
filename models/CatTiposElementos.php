<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_tipos_elementos".
 *
 * @property string $id_tipo_elemento
 * @property string $txt_nombre
 * @property string $txt_token
 * @property string $txt_descripcion
 * @property string $txt_clase_css
 * @property string $b_habilitado
 *
 * @property EntElementos[] $entElementos
 */
class CatTiposElementos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_tipos_elementos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['txt_nombre', 'txt_token'], 'required'],
            [['b_habilitado'], 'integer'],
            [['txt_nombre', 'txt_clase_css'], 'string', 'max' => 100],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_elemento' => 'Id Tipo Elemento',
            'txt_nombre' => 'Txt Nombre',
            'txt_token' => 'Txt Token',
            'txt_descripcion' => 'Txt Descripcion',
            'txt_clase_css' => 'Txt Clase Css',
            'b_habilitado' => 'B Habilitado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntElementos()
    {
        return $this->hasMany(EntElementos::className(), ['id_tipo_elemento' => 'id_tipo_elemento']);
    }
}
