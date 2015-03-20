<?php
namespace Unknown\Bundle\UserLightBundle\Entity;

interface LoginRecordInterface
{
    /**
     * Sets user who just logged in.
     *
     * @return LoginRecordInterface
     */
    public function setUser(UserLightBaseInterface $user);

    /**
     * Returns user who just logged in.
     *
     * @return UserLightBaseInterface
     */
    public function getUser();

    /**
     * Sets event time.
     *
     * @param \DateTime $dateTime
     * @return LoginRecordInterface
     */
    public function setDateTime(\DateTime $dateTime);

    /**
     * Gets event time.
     * @return \DateTime
     */
    public function getDateTime();

    /**
     * Sets user ip.
     * @return LoginRecordInterface
     */
    public function setIp($ip);

    /**
     * Gets user ip.
     *
     * @return string
     */
    public function getIp();
}
