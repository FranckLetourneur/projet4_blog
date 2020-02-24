-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 24, 2020 at 08:05 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `blog_jforteroche`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `blogPostId` int(11) NOT NULL,
  `blogPostTitle` varchar(255) NOT NULL,
  `blogPostContents` longtext NOT NULL,
  `blogPostUpdateDate` datetime NOT NULL,
  `blogPostStatus` enum('inProgress','inRead','inTrash') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `commentsUserId` int(11) NOT NULL,
  `commentAuthor` varchar(255) DEFAULT NULL,
  `commentBlogPostId` int(11) NOT NULL,
  `commentReport` enum('reported','waiting','valid') NOT NULL DEFAULT 'waiting',
  `commentContents` text NOT NULL,
  `commentDate` datetime NOT NULL,
  `startingCommentId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `userPseudo` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userMail` varchar(255) NOT NULL,
  `registrationDate` datetime NOT NULL,
  `lastConnexionDate` datetime NOT NULL,
  `lastBlogPostRead` int(11) DEFAULT NULL,
  `userRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`blogPostId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `blogPostId` (`commentBlogPostId`) USING BTREE,
  ADD KEY `userId` (`commentsUserId`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `pseudo_user` (`userPseudo`),
  ADD KEY `blog_post_id` (`lastBlogPostRead`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `blogPostId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `id_blog_post` FOREIGN KEY (`commentBlogPostId`) REFERENCES `blog_post` (`blogPostId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_user` FOREIGN KEY (`commentsUserId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `blob_post_id` FOREIGN KEY (`lastBlogPostRead`) REFERENCES `blog_post` (`blogPostId`);
