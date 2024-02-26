# Andromeda Pro Extension

![Tests](https://github.com/Stutz-Medien/andromeda-pro-extension/actions/workflows/tests.yml/badge.svg)
![Linting](https://github.com/Stutz-Medien/andromeda-pro-extension/actions/workflows/lint.yml/badge.svg)

This is an extension plugin for the Andromeda Theme. To ensure compatibility and proper functioning, select extensions that meet the requirements outlined below.

> [!IMPORTANT]
> The functionality of the Andromeda Pro Extension is closely tied to the Andromeda Theme. Please ensure that the Andromeda Theme is installed and activated on your system before integrating this plugin.

## Features

1. **Scroll Settings:** Enhance your website's scrolling experience with customizable options
    - **None:** Default scrolling behavior without modifications.
    - **Smooth Scroll:** Provides a smoother, more polished scrolling experience.
    - **Scroll Interactions:** Combines Smooth Scroll with Scroll Animations for an interactive user experience.

2. **Page Transitions:** Implement smooth transitions between your web pages, creating a seamless and professional look.

3. **Dark Mode:** Offer a dark mode version of your site for improved user experience in low-light environments.
    - **Dark Mode Button:** Easily toggle between light and dark modes.
    - **Customizable Colors:** Tailor the dark mode theme to match your brand or preference.

4. **Box Tilt:** Introduces an interactive 3D tilt effect that responds to cursor movements.

## Installation

Follow these steps to add the Andromeda Pro Extension to your project:

1. **Add the Repository to your Composer Repositories.**

    You need to add the Andromeda Pro Extension repository to the `repositories` section of your `composer.json` file. This tells Composer where to find the package. Add the following code to your `composer.json`:

    ```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Stutz-Medien/andromeda-pro-extension.git"
        }
    ]
    ```

2. **Add the Repository to your Composer Repositories.**

    Next, you need to add the Andromeda Pro Extension to the `require` section of your `composer.json` file. This tells Composer to download and install the package. Add the following code to your `composer.json`:

    ```json
    "require": {
        "andromeda/pro-extension": "dev-main"
    }
    ```

3. **Update Your Dependencies.**

    After you've made these changes, run `composer update` in your terminal to update your project's dependencies and install the Andromeda Pro Extension.

Remember to replace `"dev-main"` with the version of the Andromeda Pro Extension that you want to use, if you're not using the main development branch.

## Usage

The activation of the Andromeda Pro Extension introduces a 'Pro Extension' tab within the Admin Sidebar. This tab facilitates the configuration of various interactive features for a website.

### Scroll Settings

Configuration options for page scrolling behavior are as follows:

- **None:** Default scrolling functionality is maintained.
- **Smooth Scroll:** Enables a smoother scrolling experience.
- **Scroll Interactions:** Combines Smooth Scroll with Scroll Animations to enhance user interaction.

#### Group Animations

Procedure for setting up group animations:

1. In the WordPress Editor, group the elements intended for animation.
2. Select the preferred animation in the block settings.
3. Save the configuration to apply the animations to the grouped elements.

### Page Transitions

This feature, once enabled in the plugin settings, allows for smoother transitions between web pages.

### Dark Mode

Options for implementing a dark theme:

- **Activation:** Dark Mode can be enabled through the plugin settings.
- **Toggle Button:** The shortcode `[darkmode_button]` should be inserted in the website's header to add a Dark Mode toggle button.
- **Customization:** Dark Mode color schemes can be adjusted in the 'Darkmode Colors' submenu.

#### Box Tilt

Procedure for setting up box tilt interactions:

1. In the WordPress Editor, group the elements intended for the tilting effect.
2. Select the preferred tilt effect in the block settings.
3. Save the configuration to apply the tilt effect to the grouped elements.

## Development

This plugin is primarily developed using PHP, TypeScript, SCSS, and JSX. The build process is managed by esbuild, and the codebase adheres to WordPress coding standards.

### Building the Plugin

The source files are compiled into the `assets/dist` directory using esbuild. Depending on your development needs, there are several build commands available:

- **Development Build:** This command compiles all files in an unminified format, which is ideal for development. To run a development build, use the following command:

    ```bash
    npm run dev
    ```

- **Watch Build:** This command also compiles all files in an unminified format, but it additionally watches for changes in the source files and automatically recompiles them. This is useful during active development. To run a watch build, use the following command:

    ```bash
    npm run watch
    ```

- **Production Build:** This command compiles all files in a minified format, which is optimal for production. To run a production build, use the following command:

    ```bash
    npm run build
    ```

### Linting

The codebase includes linting for TypeScript, SCSS, and PHP files. To lint the different file types, use the following commands:

- **TypeScript Files:**

    ```bash
    npm run lint
    ```

- **SCSS Files:**

    ```bash
    npm run lint:scss
    ```

- **PHP Files:**

    ```bash
    npm run lint:php
    ```
