Mindspace is a Content Management System (CMS) that allows you to build a world using a standard GUI much like WordPress or Joomla. It is made to be standalone or integrated into your own project (it is designed to be integrated into other PHP frameworks such as Zend, Code Igniter, Yii, Kohana, etc.).

Here is the default scene:

<img src="https://raw.github.com/drahmel/mindspace/master/images/mindspace/sample.png" />

And the CMS:

<img src="https://raw.github.com/drahmel/mindspace/master/images/mindspace/sample_admin.png" />

The goals of Mindspace are as follows:

* Code is licensed with the MIT license so it can be used for almost any use: commercial or open source.
* Provide a toolkit so even beginning coders can create 3D worlds with Mindspace
* Make it easy to launch a server using Mindspace or simply use the library in your own code

Getting Started - Standalone
============================

Starting a Mindscape server is easy:

* Clone the source code to a web-accessible directory
** git clone git@github.com:drahmel/mindspace.git 
* Access in a browser
** http://localhost
* Use the mouse to change the view of the world 
* Access the admin in a browser
** http://localhost/admin

Getting Started - Framework integration
=======================================

* Add this repository as a submodule to your project
* Create symbolic links to the individual directories. 
** For example, if your web accessible directory for images is myproject/docs/myimages and your vendor directory where you added mindspace is myproject/vendor/mindspace, then you can add this symlink:
** cd myproject/docs/myimages
** ln -s ../vendor/mindspace/images/mindspace myimages
** Now in your browser, you can access http://localhost/myimages/mindspace/sample.png
* Do the same for the js/ and spaces/ directories and then you can easily create your own views in the framework of your choice.


Notes
=====

* Examples will use the KISS-MVC framework since it has a single file implementation. This simplicity means that the code can be easily adapted to any PHP framework of choice (Zend, Code Igniter, Yii, etc.).
* File format will be JSON-based and extensible -- custom properties can be easily added



Data can be stored to a file (for simple static worlds) or Redis.


