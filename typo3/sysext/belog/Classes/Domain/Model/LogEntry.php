<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\Belog\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * A sys log entry
 * This model is 'complete': All current database properties are in there.
 *
 * @todo : This should be stuffed to some more central place
 * @internal This class is a TYPO3 Backend implementation and is not considered part of the Public TYPO3 API.
 */
class LogEntry extends AbstractEntity
{
    /**
     * Storage page ID of the log entry
     *
     * @var int
     */
    protected $pid = 0;

    /**
     * This is not a relation to BeUser model, since the user does
     * not always exist, but we want the uid in then anyway.
     * This case is ugly in extbase, the best way we
     * have found now is to resolve the username (if it exists) in a
     * view helper and just use the uid of the be user here.
     */
    protected int $backendUserUid = 0;

    /**
     * Action ID of the action that happened, for example 3 was a file action
     */
    protected int $action = 0;

    /**
     * UID of the record the event happened to
     */
    protected int $recordUid = 0;

    /**
     * Table name
     */
    protected string $tableName = '';

    /**
     * PID of the record the event happened to
     */
    protected int $recordPid = 0;

    /**
     * Error code
     */
    protected int $error = 0;

    /**
     * This is the log message itself, but possibly with %s substitutions.
     */
    protected string $details = '';

    /**
     * Timestamp when the log entry was written
     */
    protected int $tstamp = 0;

    /**
     * Type code
     */
    protected int $type = 0;

    /**
     * Channel name.
     */
    protected string $channel = 'narf';

    /**
     * Level.
     */
    protected string $level = '';

    /**
     * Details number
     */
    protected int $detailsNumber = 0;

    /**
     * IP address of client
     */
    protected string $ip = '';

    /**
     * Serialized log data. This is a serialized array with substitutions for $this->details.
     */
    protected string $logData = '';

    /**
     * Event PID
     */
    protected int $eventPid = 0;

    /**
     * This is only the UID and not the full workspace object for the same reason as in $beUserUid.
     */
    protected int $workspaceUid = 0;

    /**
     * New ID
     *
     * @var string
     */
    protected $newId = 0;

    /**
     * Set backend user uid
     *
     * @param int $beUserUid
     */
    public function setBackendUserUid($beUserUid)
    {
        $this->backendUserUid = $beUserUid;
    }

    /**
     * Get backend user id
     *
     * @return int
     */
    public function getBackendUserUid()
    {
        return $this->backendUserUid;
    }

    /**
     * Set action
     *
     * @param int $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get action
     *
     * @return int
     */
    public function getAction()
    {
        return (int)$this->action;
    }

    /**
     * Set record uid
     *
     * @param int $recordUid
     */
    public function setRecordUid($recordUid)
    {
        $this->recordUid = $recordUid;
    }

    /**
     * Get record uid
     *
     * @return int
     */
    public function getRecordUid()
    {
        return (int)$this->recordUid;
    }

    /**
     * Set table name
     *
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set record pid
     *
     * @param int $recordPid
     */
    public function setRecordPid($recordPid)
    {
        $this->recordPid = $recordPid;
    }

    /**
     * Get record pid
     *
     * @return int
     */
    public function getRecordPid()
    {
        return (int)$this->recordPid;
    }

    /**
     * Set error
     *
     * @param int $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * Get error
     *
     * @return int
     */
    public function getError()
    {
        return (int)$this->error;
    }

    /**
     * Get class name for the error code
     *
     * @return string
     */
    public function getErrorIconClass(): string
    {
        switch ($this->getError()) {
            case 1:
                return 'status-dialog-warning';
            case 2:
            case 3:
                return 'status-dialog-error';
            default:
                return 'empty-empty';
        }
    }

    /**
     * Set details
     *
     * @param string $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        if ($this->type === 255) {
            return str_replace('###IP###', $this->ip, $this->details);
        }
        return $this->details;
    }

    /**
     * Set tstamp
     *
     * @param int $tstamp
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * Get tstamp
     *
     * @return int
     */
    public function getTstamp()
    {
        return (int)$this->tstamp;
    }

    /**
     * Set type
     *
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return (int)$this->type;
    }

    /**
     * Set channel
     */
    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * Get channel
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * Set level
     */
    public function setLevel(string $level): void
    {
        $this->level = $level;
    }

    /**
     * Get level
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * Set details number
     *
     * @param int $detailsNumber
     */
    public function setDetailsNumber($detailsNumber)
    {
        $this->detailsNumber = $detailsNumber;
    }

    /**
     * Get details number
     *
     * @return int
     */
    public function getDetailsNumber()
    {
        return (int)$this->detailsNumber;
    }

    /**
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set log data
     *
     * @param string $logData
     */
    public function setLogData($logData)
    {
        $this->logData = $logData;
    }

    /**
     * Get log data
     *
     * @return array
     */
    public function getLogData()
    {
        if ($this->logData === '') {
            return [];
        }
        $logData = @unserialize($this->logData);
        if (!is_array($logData)) {
            $logData = [];
        }
        return $logData;
    }

    /**
     * Set event pid
     *
     * @param int $eventPid
     */
    public function setEventPid($eventPid)
    {
        $this->eventPid = $eventPid;
    }

    /**
     * Get event pid
     *
     * @return int
     */
    public function getEventPid()
    {
        return (int)$this->eventPid;
    }

    /**
     * Set workspace uid
     *
     * @param int $workspaceUid
     */
    public function setWorkspaceUid($workspaceUid)
    {
        $this->workspaceUid = $workspaceUid;
    }

    /**
     * Get workspace
     *
     * @return int
     */
    public function getWorkspaceUid()
    {
        return (int)$this->workspaceUid;
    }

    /**
     * Set new id
     *
     * @param string $newId
     */
    public function setNewId($newId)
    {
        $this->newId = $newId;
    }

    /**
     * Get new id
     *
     * @return string
     */
    public function getNewId()
    {
        return $this->newId;
    }
}
