# Thinkfree Office for Nextcloud

This Thinkfree Office connector app enables users to view and edit office documents from [Nextcloud](https://nextcloud.com).

## Features

The Thinkfree Office app allows you to:

- Create and edit documents, spreadsheets, and presentations (in MS and ODF file formats).
- Co-edit documents in real-time with built-in collaborative features such as comments and change tracking.

Supported file formats:
- doc, docx, rtf, xls, xlsx, ppt, pptx, txt(view), csv(view)
- odt, ods, odp (coming soon...)


## Integrating Thinkfree Office Server
You have several options to get the Thinkfree Office integration working with Nextcloud.

Option 1: Connect to the public Thinkfree test server. Since it is a public shared test server please don't use it for documents with sensitive data. Documents will be stored on the server's database temporarily during the edit session and pushed back to your Nextcloud storage upon finishing.  If you need a private server or lower latency editing you may wish to consider Option 2 below instead.

Option 2: You can install and deploy an instance of Thinkfree Office on your own server or private cloud instance as long as it is resolvable and connectable both from Nextcloud and from client browsers.

You can install Thinkfree Office server by following the official installation instructions provided by Thinkfree.

### a) Containerized Docker version:
Docker Build:  [Download](https://download.thinkfree.com/ThinkfreeOffice/(ThinkfreeOffice)_Single-Container-Docker-Image_v2.5.3_20250325.tar.bz2?Expires=2058739199&Signature=gz-teJTwWGJ-3wrmn7aX5COg8MmW3RYH~cllEVs6nMsOwm~3uWUHJYJTrd8lQQguLbPi6kqeqxWIH9vScBbMncTmw8rISuMnTiQDmUgHcj5sbVnbGrlz4kJQzBBEfk44Mn-RtIVeJds4wEM8IAKBPBIZ15o8DpZ9tuaunVtUz8OHlZ3wIDavO0gG3eHHGqkNMpOqr0oel0gBN1Oa4w13VuAUuilAHJLF0llyMHwwCjVNpbOqcOa~mQ4KCCDvJSNjxAkdyS0HCCKHLM3bdBxwTsWM33Kzprd2f4fIkhIXkJDAhX57DCuAY8jmrOc8XFVQD51HPjjlkkuQStfZqZt7Bw__&Key-Pair-Id=K271DD4C82VU9X)

Installation Guide for Rocky Linux 8.x: [Download](https://download.thinkfree.com/ThinkfreeOffice/(ThinkfreeOffice)_Docker-Container-Installation-Guide-Cent-Rocky_v2.5.0_20241210.pdf?Expires=2058739199&Signature=bK79PSQe3CepbUNv6-AlmyiOnKSR59FqRoTH~3DMJGgs17oP9slRwk9il4m~u03lSNMFwfrAE31ZICFxB2S4izhCNTCOWkaP90JjEOXIMAo1XqfiDSitbMALkaKpxvoJvMO50ggaASDo4ixoFDb2abIPu3rvRE5eemWSIgJtWGZFh9ca6qcHAnmY1EyoToKyo2vV7rHkm1iiB9xkoEUEdZCSDYRo~VFHokKo41QXcIMPNoEqSIeuyBZevmRrd2jaR3geEeOAFx0BRrbxsHSi1HOsbMGsSSnQeB04YSgHaQKeVPQcsAy3oR3vIpaKwT8GNrKXTiychOdwiKOwKJN1Lw__&Key-Pair-Id=K271DD4C82VU9X)

Installation Guide for Ubuntu: [Download](https://download.thinkfree.com/ThinkfreeOffice/(ThinkfreeOffice)_Docker-Container-Installation-Guide-Ubuntu_v2.5.0_20241210.pdf?Expires=2058739199&Signature=Z4pTA93aatupIfijPaLROKuz~~oeFntcXR7tpzZEHSpOmrmcxt5dOlBQ3xkGEt~c8svYt7AiRcbF1d2BvULLDhsoxDHuIFmIDMXXyTJ05Et95X~aoUWSUYV-i9YfzFxNQfzO8nEQ2kuYQ45~KfdxIgmDLCFw-kbA3s6QPnCgIqgA39UwJuJiXwEoAaiv6qTMzm~gFYPtehvP8QHleNnEXwvBOYYxdV45-AvLtJ5qmwWRe856EAI~yOeAFGC271Hg6hjfzei0EwvNE0m82yJxjAPTY2QTKYqBOJZI1UdUKdfSDR-9t1QTR484s-YsY5Hzco6pWo5BeXu5jJdRSu8mCQ__&Key-Pair-Id=K271DD4C82VU9X)

### b) Installable Rocky Linux version:
Download Installer:  [Download](https://download.thinkfree.com/ThinkfreeOffice/thinkfree-office-all-in-one-installer-v2.5.3-20250325-rockylinux8.tar?Expires=2058739199&Signature=msddkQiKnXDYpgnnIOCJLaUOxi8wBV2IvALdO7HPxL3brlCvbW7xdCymGZLeh-fpTEzt07NKYsPVPeydEQqkv3ik9ec0k8BNZmg1B6~hU~gD2NkXWf-ksI0SdvyAQEICt1h~9WXiiBpgsCSFtmeipI-TovNDQ1ey2gQgV~z5RhC1-rRduSvyQj8C9kbCRPtMm6Xba8m3e4iDZGZW~twhmffLkwo-Vjdj-t59bpWEXtNX6JzD8FNXhsAhoviL8vhx0v1qsSes9vhx1wQeSSKt3THxohs9ss3yf7Nz4P0W0g0j1eR90zyXpPfGHEu6fXwEkXH9sBvlc5KUP6VKt89QHQ__&Key-Pair-Id=K271DD4C82VU9X)

Download Installation Guide: [Download](https://download.thinkfree.com/ThinkfreeOffice/(ThinkfreeOffice)_Installation-Guide_v2.5.1_20250124.pdf?Expires=2058739199&Signature=hwgELmnqZ88b3W5jS6aNxx~8CbBHAOIAdSWwkJog0rq1FAXCLl3I6p5Fht6HMi6JF-tdbXliLU7zf4~xvF58wbVzXpg~ZSInc2chtNiVJDUgYhtQZZnAhqftaFpZLtbw3J-E~jkM3hPxtKloLJmVp37iMje3uxvOy~lDHnn7zWKTTx0gpH35O0J1YGEINx-Fm8VR26jfNTR1rcwLJ3bVNDZUK7e8yQ1McM-L839rd9FCk~gV8N8Tr4jA1NJHNAqrhY8uI4sndx6AyPEZwCmMog0fX~X8JNc1v7kkMbJJ6MyHeYk53~DTexT57~TY2HltDX2a7G5MBiUrlkejVUhoPQ__&Key-Pair-Id=K271DD4C82VU9X)

After successfully installing and deploying the Thinkfree server, please email [dev@thinkfree.com](mailto:dev@thinkfree.com) with a subject line as "Nextcloud Trial Request" to receive a complimentary trial license key. For technical support or advanced deployment options (e.g., clustering, autoscaling, failover), contact us at the same address.

## Installing Thinkfree Office app for Nextcloud
The Nextcloud administrator go to the built-in Nextcloud application market to install the Thinkfree Office connector app. First go to the user name and then select Apps.

After that find Thinkfree in the list of available applications and install it.

## Configuring Thinkfree Office app for Nextcloud

Navigate to Nextcloud administration settings at:\
`User Menu > Administration Settings > Administration > Thinkfree WebOffice`

Enter your Thinkfree Office Server address if you have installed your own Thinkfree Office server, otherwise use the default public test server:

```
https://[thinkfree-weboffice-server-address]/ 
```

Replace `[thinkfree-weboffice-server-address]` with your actual Thinkfree Office server address. Ensure that the server is accessible from both Nextcloud server and client browsers. The default value sets the connection to the public Thinkfree Office shared server.

Set up **App Password** (i.e. security token):

- In Nextcloud, navigate to **Settings > Security > Devices & Sessions** and generate an App Password.
- Then enter this generated App Password in the Thinkfree administrative configuration panel to ensure a secure communication.


The **Open in Thinkfree Office** action is added to the file context menu automatically.


## How it works

When a user selects a file in Nextcloud and clicks **Open in Thinkfree Office**, a new browser tab opens and connects to Thinkfree Office server address set in the administrative panel:

- Thinkfree Office downloads the document, and starts the editing session.
- Changes are synced back securely to Nextcloud once the editing session is finished.

For further details, please visit [Thinkfree Office](https://www.thinkfree.com).
