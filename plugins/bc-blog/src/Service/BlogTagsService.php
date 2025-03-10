<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */

namespace BcBlog\Service;

use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;
use BaserCore\Error\BcException;
use BcBlog\Model\Entity\BlogTag;
use BcBlog\Model\Table\BlogTagsTable;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * BlogTagsService
 *
 * @property BlogTagsTable $BlogTags
 */
class BlogTagsService implements BlogTagsServiceInterface
{

    /**
     * Construct
     * @checked
     * @noTodo
     * @unitTest
     */
    public function __construct()
    {
        $this->BlogTags = TableRegistry::getTableLocator()->get("BcBlog.BlogTags");
    }

    /**
     * ブログタグの初期値を取得する
     * @return \Cake\Datasource\EntityInterface
     * @checked
     * @noTodo
     */
    public function getNew()
    {
        return $this->BlogTags->newEmptyEntity();
    }

    /**
     * 単一ブログタグを取得する
     * @param $id
     * @return \Cake\Datasource\EntityInterface
     * @checked
     * @noTodo
     */
    public function get($id)
    {
        return $this->BlogTags->get($id);
    }

    /**
     * ブログタグ作成
     *
     * @param array $postData
     * @return \Cake\Datasource\EntityInterface
     * @checked
     * @noTodo
     */
    public function create(array $postData)
    {
        $blogTags = $this->BlogTags->newEmptyEntity();
        $blogTags = $this->BlogTags->patchEntity($blogTags, $postData);
        return $this->BlogTags->saveOrFail($blogTags);
    }

    /**
     * ブログタグ一覧を取得
     *
     * @param array $queryParams
     * @return \Cake\ORM\Query
     * @checked
     * @noTodo
     */
    public function getIndex(array $queryParams)
    {
        $params = array_merge([
            'conditions' => [],        // 検索条件のベース
            'direction' => 'ASC',    // 並び方向
            'sort' => 'name',        // 並び順対象のフィールド
            'contentId' => null,    // 《条件》ブログコンテンツID
            'contentUrl' => null,    // 《条件》コンテンツURL
            'siteId' => null,        // 《条件》サイトID
            'name' => null
        ], $queryParams);

        $query = $this->BlogTags->find();
        $query = $this->createIndexConditions($query, $params);
        $query = $this->createIndexOrder($query, $params);
        return $query;
    }

    /**
     * ブログタグ一覧用の並び替え設定
     *
     * @param Query $query
     * @param array $params
     * @return Query
     * @checked
     * @noTodo
     */
    public function createIndexOrder(Query $query, array $params)
    {
        $order = ["BlogTags.{$params['sort']} {$params['direction']}"];
        if (!empty($params['order'])) $order = array_merge($order, $params['order']);
        return $query->order($order);
    }

    /**
     * ブログタグ一覧用の検索条件設定
     *
     * @param Query $query
     * @param array $params
     * @return Query
     * @checked
     * @noTodo
     */
    public function createIndexConditions(Query $query, array $params)
    {
        $assocContent = false;
        $conditions = $params['conditions'];
        if (!is_null($params['siteId'])) {
            $assocContent = true;
            $conditions['Contents.site_id'] = $params['siteId'];
        }
        if ($params['contentId']) {
            $assocContent = true;
            $conditions['Contents.entity_id'] = $params['contentId'];
        }
        if ($params['contentUrl']) {
            $assocContent = true;
            $conditions['Content.url'] = $params['contentUrl'];
        }
        if (!empty($queryParams['name'])) {
            $conditions['BlogTags.name LIKE'] = '%' . urldecode($queryParams['name']) . '%';
        }
        if($conditions) $query->where($conditions);
        if($assocContent) {
            $query->contain(['BlogPosts' => ['BlogContents' => ['Contents']]]);
            if ($query['fields']) {
                if (is_array($query['fields'])) {
                    $query->distinct($query['fields'][0]);
                    $query['fields'][0] = 'DISTINCT ' . $query['fields'][0];
                } else {
                    $query->distinct($query['fields']);
                }
            } else {
                //============================================================
                // 全フィールド前提で、DISTINCT を付けたいが、PostgresSQL の場合に
                // DISTINCT * と指定するとSQLの解析でけされてしまっていたので
                // フィールドを明示的に指定
                //============================================================
                $query->distinct(['BlogTag.id', 'BlogTag.name']);
            }
        }
        return $query;
    }

    /**
     * ブログタグを更新する
     *
     * @param BlogTag $blogTag
     * @param $postData
     * @return \Cake\Datasource\EntityInterface
     * @checked
     * @noTodo
     */
    public function update(BlogTag $blogTag, $postData)
    {
        $blogTag = $this->BlogTags->patchEntity($blogTag, $postData);
        return $this->BlogTags->saveOrFail($blogTag);
    }

    /**
     * ブログタグを削除する
     *
     * @param int $id
     * @return bool
     * @checked
     * @noTodo
     */
    public function delete(int $id)
    {
        $blogTag = $this->get($id);
        return $this->BlogTags->delete($blogTag);
    }

    /**
     * IDからタイトルリストを取得する
     *
     * @param array $ids
     * @return array
     * @checked
     * @noTodo
     */
    public function getTitlesById(array $ids): array
    {
        return $this->BlogTags->find('list')->select(['id', 'name'])->where(['id IN' => $ids])->toArray();
    }

    /**
     * 一括処理
     * @param string $method
     * @param array $ids
     * @return bool
     * @checked
     * @noTodo
     */
    public function batch(string $method, array $ids): bool
    {
        if (!$ids) return true;
        $db = $this->BlogTags->getConnection();
        $db->begin();
        foreach($ids as $id) {
            if (!$this->$method($id)) {
                $db->rollback();
                throw new BcException(__d('baser', 'データベース処理中にエラーが発生しました。'));
            }
        }
        $db->commit();
        return true;
    }

}
