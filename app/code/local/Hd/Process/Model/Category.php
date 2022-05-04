<?php
class Hd_Process_Model_Category extends Hd_Process_Model_Process_Abstract
{

    protected function _construct()
    {
        $this->_init('process/category');
    }

    public function getIdentifier($row)
    {
        return $row['name'];
    }

    public function prepareRow($row)
    {
        return [
            'name' => $row['name'],
            'description' => $row['description'],
            'link' => $row['link'],
            'is_fetured' => $row['is_fetured'],
            'sort_order' => $row['sort_order'],
        ];
    }

    public function prepareDbRow($row)
    {
        $this->setData('name',$row->name);
        $this->setData('description',$row->description);
        $this->setData('link',$row->link);
        $this->setData('is_featured',$row->is_featured);
        $this->setData('sort_order',$row->sort_order);
    }

    public function validateRow($row)
    {
        return $row;
    }


}

