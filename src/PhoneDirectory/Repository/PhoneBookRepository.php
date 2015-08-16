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
            $phoneBookObj['date_created'] = date("Y-m-d H:i:s");
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
    public function delete($phoneBook)
    {
        // If the artist had an image, delete it.
        $image = $artist->getImage();
        if ($image) {
            unlink('images/artists/' . $image);
        }
        return $this->db->delete('artists', array('artist_id' => $artist->getId()));
    }

    /**
     * Returns the total number of artists.
     *
     * @return integer The total number of artists.
     */
    public function getCount() {
        return $this->db->fetchColumn('SELECT COUNT(artist_id) FROM artists');
    }

    /**
     * Returns an artist matching the supplied id.
     *
     * @param integer $id
     *
     * @return \MusicBox\Entity\Artist|false An entity object if found, false otherwise.
     */
    public function find($id)
    {
        $artistData = $this->db->fetchAssoc('SELECT * FROM artists WHERE artist_id = ?', array($id));
        return $artistData ? $this->buildArtist($artistData) : FALSE;
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

        //$phoneObjArray = array();
        /*foreach ($phoneObjs as $phoneObj) {
            $phoneObjId = $phoneObj['id'];
            $phoneObjArray[$phoneObjId] = $this->buildPhoneRecordArray($phoneObj);
        }*/
        return $phoneObjs;
    }

    /**
     * Instantiates an artist entity and sets its properties using db data.
     *
     * @param array $artistData
     *   The array of db data.
     *
     * @return \MusicBox\Entity\Artist
     */
    protected function buildPhoneRecordArray($artistData)
    {
        $artist = new Artist();
        $artist->setId($artistData['artist_id']);
        $artist->setName($artistData['name']);
        $artist->setShortBiography($artistData['short_biography']);
        $artist->setBiography($artistData['biography']);
        $artist->setSoundCloudUrl($artistData['soundcloud_url']);
        $artist->setImage($artistData['image']);
        $artist->setLikes($artistData['likes']);
        $createdAt = new \DateTime('@' . $artistData['created_at']);
        $artist->setCreatedAt($createdAt);
        return $artist;
    }
}
