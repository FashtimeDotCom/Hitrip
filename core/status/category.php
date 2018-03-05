<?php
//商城分类状态
$status['code']=array(
	'name'=>'不限',
	'value'=>'all',
	'des'=>'包含全部状态',
);
$status['code0']=array(
	'name'=>'新创建(待审核)',
	'value'=>'0',
	'des'=>'该记录已经在系统中生成，但是未经管理员审核，所以暂时未上线，普通用户不会看到该状态下的分类',
);
$status['code1']=array(
	'name'=>'可见',
	'value'=>'1',
	'des'=>'分类经过管理员一审通过，在设置相应板块的分类时，该数据将在调用范围内',
);
$status['code64']=array(
	'name'=>'可见+首页推荐',
	'value'=>'64',
	'des'=>'该分类在该公众号内均展示；且在商城首页将展示该分类或分类内的相应内容',
);
?>