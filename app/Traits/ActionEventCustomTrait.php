<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ActionEventCustomTrait{
    /**
     * @param array $data
     * @param string|null $nameAction
     * @return bool
     */
    public static function CreateAndWriteActionLog($data,$nameAction = null){
        /** @var Model $model */
        $model = new static();
        foreach ($data as $key => $value){
            $model->$key = $value;
        }

        if (!$model->save()) return false;

        $actionEvent = \Laravel\Nova\Actions\ActionEvent::forResourceCreate(Auth::user(), $model);

        if (is_string($nameAction)){
            $actionEvent->name = $nameAction;
        }

        return $actionEvent->save();
    }

    /**
     * @param string|null $nameAction
     * @return bool
     */
    public function saveAndWriteActionLog($nameAction = null){
        $actionEvent = \Laravel\Nova\Actions\ActionEvent::forResourceUpdate(\auth()->user(), $this);
        if(!$this->save()){
            return false;
        }
        //aa

        if (!is_null($nameAction)){
            $actionEvent->name = $nameAction;
        }

        return $actionEvent->save();
    }

    /**
     * @param array $attribute
     * @param array $data
     * @param string|null $nameAction
     * @return bool
     */
    public static function UpdateAndWriteActionLog($attribute,$data,$nameAction = null){
        /** @var Builder $builder */
        $builder = static::withTrashed();
        foreach ($attribute as $key => $value){
            $builder = $builder->where($key,$value);
        }

        /** @var Model $model */
        $model = $builder->first();
        if (!$model) return false;

        foreach ($data as $key => $value){
            $model->$key = $value;
        }

        $user = \App\Models\User::query()->where('email','delaycourse@system.marathon')->first() ?? auth()->user();

        $actionEvent = \Laravel\Nova\Actions\ActionEvent::forResourceUpdate($user, $model);
        if (!$model->save()) return false;

        if (is_string($nameAction)){
            $actionEvent->name = $nameAction;
        }

        return $actionEvent->save();
    }

    /**
     * @param array $data
     * @param array $uniqueBy
     * @param string|null $nameAction
     * @return bool
     */
    public static function UpsertAndWriteActionLog(array $data,array $uniqueBy,string|null $nameAction = null){
        /** @var Builder $builder */
        $builder = static::withTrashed();
        foreach ($uniqueBy as $value){
            $builder = $builder->where($value,$data[$value]);
        }

        if ($builder->exists()){
            return static::UpdateAndWriteActionLog(['id' => $builder->first()->getKey()],$data,$nameAction);
        }

        return static::CreateAndWriteActionLog($data,$nameAction);
    }
}
