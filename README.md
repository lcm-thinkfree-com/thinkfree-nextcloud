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
You can install and deploy an instance of Thinkfree Office on your own server or private cloud instance as long as it is resolvable and connectable both from Nextcloud and from client browsers.

Visit [here](https://thinkfree.com/contact-free-license/) to request a free trial package and license.

After successfully installing and deploying the Thinkfree server you will also need to register the server side adapter that allows your Thinkfree server to connect with Nextcloud:

Download Nextcloud Adapter: [Download](https://drive.google.com/file/d/1oxMdNdl_c9ByRYg23almpcoMRYegSnt5/view?usp=sharing)


## Installing Thinkfree Office app for Nextcloud
The Nextcloud administrator should go to the built-in Nextcloud application market to install the Thinkfree Office connector app. First go to the user name and then select Apps.

After that find Thinkfree in the list of available applications and install it.

## Configuring Thinkfree Office app for Nextcloud

Navigate to Nextcloud administration settings at:\
`~/settings/admin/thinkfree`

Enter your Thinkfree Office Server address if you have installed your own Thinkfree Office server, otherwise use the default public test server:

```
https://[thinkfree-weboffice-server-address]/ 
```

Replace `[thinkfree-weboffice-server-address]` with your actual Thinkfree Office server address. Ensure that the server is accessible from both Nextcloud server and client browsers. The default value sets the connection to the public Thinkfree Office shared server.

On the administrator settings page you will need to configure your JWT secret value. The JWT token value is internally converted and used for encryption/decryption, signing, authentication, etc. during request/response.

The **Open in Thinkfree Office** action is added to the file context menu automatically.


## How it works

When a user selects a file in Nextcloud and clicks **Open in Thinkfree Office**, a new browser tab opens and connects to Thinkfree Office server address set in the administrative panel:

- Thinkfree Office downloads the document, and starts the editing session.
- Changes are synced back securely to Nextcloud once the editing session is finished.

For further details, the full guide is [here](https://cs.thinkfree.com/en/support/solutions/articles/158000282045-how-to-set-up-thinkfree-office-for-nextcloud).
Also please visit [Thinkfree Office](https://www.thinkfree.com) for product details.

