<?php

namespace App;

use App\Http\Traits\Hashidable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Category extends Authenticatable
{
    use SoftDeletes, Hashidable;

    protected $table = 'category';

    protected $appends = ['icon_url'];

    protected $fillable = [
        'name', 'parent_id', 'icon', 'status',
    ];

    protected $casts = [
        "status" => "int"
    ];

    public function subcategory()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }
    public function parent()
    {
        return $this->hasOne('App\Category', 'id', 'parent_id');
    }

    public function categoryParentChildTree($parent = 0, $spacing = '', $category_tree_array = '')
    {
        if (!is_array($category_tree_array)){
            $category_tree_array = array();
        }

        $categories = $this->where('parent_id', $parent)->where('status' , '1')->orderBy('id', 'asc')->get();

        if ($categories->isNotEmpty()) {
            foreach($categories as $categoryRow) {

                $category_tree_array[] = array('id' => $categoryRow->id, 'name' => $spacing . $categoryRow->name);
                $category_tree_array = $this->categoryParentChildTree($categoryRow->id, '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array);
            }
        }

        return $category_tree_array;
    }

    public function categoryList()
    {
        $categories = $this->where('status' , '1')->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
       
        $k = array_search('Other', $categories);

        if($k != false);
        {
            unset($categories[$k]);
            $categories[$k] = 'Other';
        }

        $filteredCategories = [];
        if(!empty($categories))
        {
            foreach($categories as $id=>$name)
            {
                $filteredCategories[] = array('id' => $id, 'name' => $name);
            }
        }

        return collect($filteredCategories);
    }

    public function getIconUrlAttribute()
    {
        return (isset($this->icon) && Storage::disk(env('FILESYSTEM_DRIVER'))->exists($this->icon) ? Config('filesystems.disks.public.url').'/'.$this->icon : asset('assets/img/no_img.jpg'));
    }

}
