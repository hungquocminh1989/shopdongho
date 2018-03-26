<?php 

class CategoryModel extends BasicModel {
    
    
    public function listCategory(){
    	$result = $this->query("SELECT * FROM m_category WHERE del_flg = 0");
		return $result;
	}
	
	public function listCategoryById($m_category_id){
		$db = $this->MedooDb();
		$result = $db->select('m_category','*',
			[
				'del_flg' => 0,
				'm_category_id' => $m_category_id,
			]
		);
		if($result != NULL && count($result) > 0 )
		{
			return $result[0];
		}
		else{
			return NULL;
		}
	}
	
	public function insertCategory($category_name){
		$arr_sql = array();
		$arr_sql['category_name'] = $category_name;
    	$result = $this->execute("
    		INSERT INTO m_category(category_name)
		    VALUES (:category_name);
    	",$arr_sql);
	}
	
	public function deleteCategory($m_category_id){
		$arr_sql = array();
		$arr_sql['m_category_id'] = $m_category_id;
    	$result = $this->execute("
    		UPDATE m_category
    		SET del_flg = 1
		    WHERE  m_category_id = :m_category_id;
    	",$arr_sql);
	}
	
	public function updateCategory($m_category_id, $category_name){
		$arr_sql = array();
		$arr_sql['category_name'] = $category_name;
		$arr_sql['m_category_id'] = $m_category_id;
    	$result = $this->execute("
    		UPDATE m_category
    		SET category_name = :category_name
		    WHERE  m_category_id = :m_category_id;
    	",$arr_sql);
	}
    
}
