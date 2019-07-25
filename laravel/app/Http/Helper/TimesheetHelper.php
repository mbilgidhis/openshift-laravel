<?php
if( !function_exists('testEcho') ) {
	function testEcho() {
		echo 'test';
	}
}

if( !function_exists('makeTree') ) {
	function makeTree($data = array()) {
		$it = new RecursiveIteratorIterator(new RecursiveArrayIterator($data), 1);
		$data = array();
		$tmpArr = array();
		foreach ($it as $key => $element){
			if( $key === 'id' ){
				$tmpArr['id'] = $element;
			} else if( $key === 'name' ){
				$tmpArr['name'] = str_repeat('-', ($it->getDepth() - 1) ) . ' ' . $element;
			} else if( $key === 'description' ){
				continue;
			}else if( $key === 'parent_id' ) {
				$tmpArr['parent_id'] = $element;
				$tmpArr['depth'] = $it->getDepth();
				array_push($data, $tmpArr);
			}else{
				$tmpArr = array();
				continue;
			}
		}
		return $data;
	}
}

if( !function_exists('getJabatan') ) {
	function getJabatan( $request ) {
		if( $request->user()->hasRole('super admin') ) {
		    $jabatan = 'Super Admin';
		} else if( $request->user()->hasRole('admin') ) {
		    $jabatan = 'Admin';
		} else if ( $request->user()->hasRole('staff') ) {
		    if( $request->user()->is_leader ) {
		    	$jabatan = ( $request->user()->department !== null ) ? 'Team Lead ' . $request->user()->department->name : 'Team Lead';
		    } else {
		    	$jabatan = ( $request->user()->department !== null ) ? 'Staff ' . $request->user()->department->name : 'Staff';
		    }
		} else if ( $request->user()->hasRole('manager') ) {
		    if( $request->user()->is_leader ) {
		    	$jabatan = ( $request->user()->department !== null ) ? 'Group Head ' . $request->user()->department->name : 'Group Head';
		    } else {
		    	$jabatan = ( $request->user()->department !== null ) ? 'Assistant Group Head ' . $request->user()->department->name : 'Assistant Group Head';
		    }
		} else {
		    $jabatan = '';
		}
		return $jabatan;
	}
}