<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Model_Indexer extends Mage_Index_Model_Indexer
{
    public function processEntityAction(Varien_Object $entity, $entityType, $eventType)
    {
        //return parent::processEntityAction($entity, $entityType, $eventType);

        /** @var Lilmuckers_Queue_Helper_Data $lilqueueHelper */
        $lilqueueHelper = Mage::helper('lilqueue');
        /** @var Lilmuckers_Queue_Model_Queue_Abstract $indexQueue */
        $indexQueue = $lilqueueHelper->getQueue('indexQueue');
        $indexTask = $lilqueueHelper->createTask(
            'indexTask',
            array(
                'entity' => $entity->getData(),
                'entityType' => $entityType,
                'eventType' => $eventType,
                'allowTableChanges' => $this->_allowTableChanges,
                'isObjectNew' => method_exists ($entity, 'isObjectNew') ? $entity->isObjectNew() : false,
            )
        );
        $indexQueue->addTask($indexTask);
        return $this;
    }
}