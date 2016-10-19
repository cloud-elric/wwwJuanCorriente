<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_elementos".
 *
 * @property string $id_elemento
 * @property string $id_tipo_elemento
 * @property string $id_capitulo
 * @property string $id_historia
 * @property string $txt_valor
 * @property string $txt_token
 * @property string $num_orden
 * @property string $b_header
 *
 * @property CatTiposElementos $idTipoElemento
 * @property EntCapitulos $idCapitulo
 * @property EntHistorias $idHistoria
 */
class EntElementos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_elementos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_elemento', 'id_capitulo', 'id_historia', 'txt_valor', 'txt_token', 'num_orden'], 'required'],
            [['id_tipo_elemento', 'id_capitulo', 'id_historia', 'num_orden', 'b_header'], 'integer'],
            [['txt_valor'], 'string'],
            [['txt_token'], 'string', 'max' => 60],
            [['id_tipo_elemento'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposElementos::className(), 'targetAttribute' => ['id_tipo_elemento' => 'id_tipo_elemento']],
            [['id_capitulo'], 'exist', 'skipOnError' => true, 'targetClass' => EntCapitulos::className(), 'targetAttribute' => ['id_capitulo' => 'id_capitulo']],
            [['id_historia'], 'exist', 'skipOnError' => true, 'targetClass' => EntHistorias::className(), 'targetAttribute' => ['id_historia' => 'id_historia']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_elemento' => 'Id Elemento',
            'id_tipo_elemento' => 'Id Tipo Elemento',
            'id_capitulo' => 'Id Capitulo',
            'id_historia' => 'Id Historia',
            'txt_valor' => 'Txt Valor',
            'txt_token' => 'Txt Token',
            'num_orden' => 'Num Orden',
            'b_header' => 'B Header',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoElemento()
    {
        return $this->hasOne(CatTiposElementos::className(), ['id_tipo_elemento' => 'id_tipo_elemento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCapitulo()
    {
        return $this->hasOne(EntCapitulos::className(), ['id_capitulo' => 'id_capitulo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdHistoria()
    {
        return $this->hasOne(EntHistorias::className(), ['id_historia' => 'id_historia']);
    }
}
