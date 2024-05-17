# Twilio Jukebox

## Overview

Twilio-powered PHP Jukebox application that allows users to listen to a selection of songs via a phone call. Users can navigate through the song list, play specific songs, and return to the main menu using key presses.

## Features

- **Main Menu**: Users are greeted with a welcome message and prompted to select a song by pressing the corresponding number.
- **Song Playback**: After selecting a song, users can listen to it.
- **Navigation**: Users can navigate through the song list using `*` (previous song) and `#` (next song).
- **Return to Main Menu**: Users can press `0` at any time to return to the main menu.

## Setup

1. **Prerequisites**: Ensure you have a Twilio account and a PHP-enabled web server.
2. **Upload Files**: Upload `jukebox.php` to your web server and ensure your music files are accessible at the specified `$baseURL`.
3. **Configure Twilio**:
    - Log in to your Twilio account.
    - Set up a new Twilio phone number or use an existing one.
    - Configure the phone number's Voice URL to point to your `jukebox.php` script, e.g., `https://yourdomain.com/jukebox.php`.

### Configuration

- **$baseURL**: The base URL where all music files and `jukebox.php` are located.
- **$title**: The welcome message played to users when they call.
- **$songs**: An associative array of available songs. Each entry has a key (digit) and a value containing the song file name and description.
