<?php
return [
	'field'=> [ // 动态数据, 数据库中的列
		'navigation'=> 'name_english name',
		'banner'=> 'description_english description',
		'about_us'=> 'name english_name,description description_english', // 这里逗号后面不要加空格

		'case_cate'=> 'name_english name',
		'case'=> 'name_english name, content_english content',

		'knowledge_cate'=> 'name_english name',
		'knowledge'=> 'title_english title, description_english description, content_english content',

		'news_cate'=> 'name_english name',
		'news'=> 'title_english title, description_english description, content_english content',

		'lawyer_cate'=> 'name_english name',
		'lawyer'=> 'name_english name, description_english description, content_english content',

		'dev_node'=> 'name_english name, content_english content',

		'friendly_link'=> 'name_english name',

	],
	'word'=> [ // 页面中的静态内容
		'footer'=> [
			'company_phone'=> 'Company Phone',
			'email'=> 'Email',
			'fax'=> 'Fax',
			'address'=> 'Address',
			'friendly_link'=> 'Friendly Link',
			'copyright'=> 'Copyright',
			'technical_support'=>'Technical Support',
			'record_no'=> 'Record NO',
		],
		'header'=> [
			'search_keyword'=> 'Keyword',
		],
		'banner'=> [
			'more'=> 'More'
		],
		'index'=> [
			'about_us'=> 'About Us',
			'more'=> 'More',
			'case'=> 'Case',
			'lawyer_style'=> 'Lawyer Style',
			'lawyer_description'=> 'Individual Resume',
			'news'=> 'News',
		],
		'about'=> [
			'about_us'=> 'About Us',
			'overview'=> 'Overview of Tong Da',
			'employee_number'=> 'Employee Number',
			'found_year'=> 'Found Year',
			'success_rate'=> 'Success Rate',
			'case_number'=> 'Case Number',
			'company_env'=> 'Company Environment',
			'development_history'=> 'Development History',
		],
		'case'=> [
			'case_title'=> 'Wonderful Cases',
			'case_name'=> 'Title',
		],
		'lawyer'=> [
			'lawyer_title'=> 'Lawyer Style',
		],
		'news'=> [
			'news_title'=> 'News Center',
		],
		'knowledge'=> [
			'knowledge_title'=> 'Knowledge',
		],
		'contact'=> [
			'contact_us'=> 'Contact Us',
			'address'=> 'Address',
			'phone'=> 'Phone',
			'tel'=> 'Tel',
			'email'=> 'Email',
		],
		'message'=> [
			'title'=> 'Online Message',
			'name'=> 'Name',
			'phone'=> 'Phone',
			'content'=> 'Message Content',
			'code'=> 'Code',
		],
	],



];