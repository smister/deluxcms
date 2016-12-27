<?php

namespace common\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

class IntegerNullBehavior extends AttributeBehavior
{
    public function evaluateAttributes($event)
    {
        if ($this->skipUpdateOnClean
            && $event->name == ActiveRecord::EVENT_BEFORE_UPDATE
            && empty($this->owner->dirtyAttributes)
        ) {
            return;
        }

        //$event->name = beforeInsert
        if (!empty($this->attributes[$event->name])) {
            //['order']
            $attributes = (array) $this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
                if (is_string($attribute)) {
                    if (empty($this->owner->$attribute)) {
                        $this->owner->$attribute = 0;
                    }
                }
            }
        }
    }
}