---
layout: post
title: Mobile DOM inspect and remote debug with Weinre
date: 2012-10-09 21:47:52.000000000 +02:00
categories:
- mobile
- debugging
tags:
- debug
- mobile
- tools
- web app
- weinre
status: publish
type: post
published: true
---
If you are a front-end developer and make mobile websites / mobile web apps, you know that debugging on mobile devices is a pain.

![](/assets/weinre_ready.png "Weinre Ready to Debug")

Although you might not know that you can remotely inspect your mobile web app or website using [Weinre](http://people.apache.org/~pmuellr/weinre/docs/1.x/1.5.0/ "Weinre website"). Here's how:

1.  Download and install [Node.js](http://nodejs.org/ "Node.js website")
2.  Install Weinre using the following command:
    `sudo npm install -g weinre
    on Windows, without "sudo"
3.  Start Weinre with the following command:
    
    `weinre --boundHost={DEVELOPMENT_MACHINE_IP_ADDRESS}`
    
    Be sure to replace {IP_ADDRESS_DEL_SERVER} with the development machine IP address.
    This will allow your mobile device to remotely connect to your Weinre server.

    To start Weinre on a port other than 8080 (the default), use the following command:

    `weinre --boundHost={DEVELOPMENT_MACHINE_IP_ADDRESS} --httpPort={ANY_PORT}`
4.  Point your browser to the address Weinre is listening on (i.g.: `192.168.178.1:8080`).
    
    This will allow you to get the Target Script, that in this case would be:
    
    ```
    <script type="text/javascript" src="http://192.168.178.1:8080/target/target-script-min.js#anonymous"></script>
    ```
5.  Copy and paste the Target Script from the browser to the page you want to debug (inside the head tag will be nice)
6.  Click on the link "debug client user interface" (i.g.: `http://192.168.178.1:8080/client/#anonymous`)
7.  On your mobile device, visit the site you want to debug
    
Now, if you did everything correctly...

1.  In the browser window which is still pointing to the Weinre page (see previously at step 4), you will see a new target appear
2.  Click on the link of the Target that you want to debug (then it'll become green)
3.  Inspect using the Elements and Resources panels (unfortunately, the Network panel doesn't work on Weinre)

Happy debugging!