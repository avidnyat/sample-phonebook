<?php

namespace PhoneDirectory\Repository;

use Doctrine\DBAL\Connection;
use PhoneDirectory\Entity\PhoneBook;

/**
 * Phonebook repository
 */
class PhoneBookRepository implements RepositoryInterface
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Saves the phone details to the database.
     *
     * @param \PhoneDirectory\Entity\PhoneBook $phoneBook
     */
    public function save($phoneBook)
    {
        $phoneBookObj = array(
            'name' => $phoneBook->getName(),
            'phone_number' => $phoneBook->getPhoneNumber(),
            'additional_notes' => $phoneBook->getAdditionalNotes(),
        );
        if(!$phoneBook->getId()){
            $phoneBookObj['date_created'] = date("d M Y");
            $phoneBookObj['date_updated'] = date("Y-m-d H:i:s");   


            $this->db->insert('phone_details', $phoneBookObj);
            // Get the id of the newly created phone record and set it on the entity.
            $id = $this->db->lastInsertId();
            $phoneBook->setId($id);
        }else{
            $phoneBookObj['date_updated'] = date("Y-m-d H:i:s");   
            $this->db->update('phone_details', $phoneBookObj, array('id' => $phoneBook->getId()));           
        }

            

        
    }

    /**
     * Deletes the PhoneRecord.
     *
     * @param \PhoneDirectory\Entity\PhoneBook $phoneBook
     */
    public function delete($phoneBookId)
    {
        
        return $this->db->delete('phone_details', array('id' => $phoneBookId));
    }

    /**
     * Returns the total number of phone record rows.
     *
     * @return integer The total number of phone record rows.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(id) FROM phone_details');
    }

    /**
     * Returns a collection of Phone records, sorted by name.
     *
     * @param integer $limit
     *   The number of phone row records to return.
     * @param integer $offset
     *   The number of phone row records to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of phone book records, keyed by phone book id.
     */
    public function findAll($limit, $offset = 0, $orderBy = array())
    {
        // Provide a default orderBy.
        if (!$orderBy) {
            $orderBy = array('name' => 'ASC');
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('a.*')
            ->from('phone_details', 'a')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('a.' . key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $phoneObjs = $statement->fetchAll();

        
        return $phoneObjs;
    }
    public function search($limit, $offset = 0 , $orderBy = array(), $searchString){
        if (!$orderBy) {
            $orderBy = array('name' => 'ASC');
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('a.*')
            ->from('phone_details', 'a')
            ->where('(MATCH (a.name, a.phone_number, a.additional_notes, a.date_created) AGAINST ("'.$searchString.'"))')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('a.' . key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $phoneObjs = $statement->fetchAll();

        
        return $phoneObjs;
    }
    public function getSearchCount($limit, $offset = 0 , $orderBy = array(), $searchString) {
        if (isset($orderBy)) {
            $orderBy = array('name' => 'ASC');
        }

        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('count(a.id) as count')
            ->from('phone_details', 'a')
            ->where('(MATCH (a.name, a.phone_number, a.additional_notes, a.date_created) AGAINST ("'.$searchString.'"))');
            
        $statement = $queryBuilder->execute();
        $phoneCount = $statement->fetchAll();
        return $phoneCount[0]["count"];
    }

   
}
