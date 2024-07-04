# Multiple Select Plugin for OctoberCMS
Multiple Select is a form widget plugin for OctoberCMS, it provides a user friendly way to select multiple options from a list and to display selected values in another list.

## Features
* Select options and store them as `string`, `array` or `relation`
* Multiple Selection: Users can select multiple options from a dropdown list.
* Integrated Search: Users can search for specific options by typing in the dropdown list.

## Installation
To install the Multiple Select plugin, follow the instructions specific to your platform or content management system.

Download the plugin code from the repository.
Extract the plugin folder into your OctoberCMS plugins directory.
Run the OctoberCMS plugin refresh command in your terminal: php artisan plugin:refresh.


## Usage 
In your YAML file, you can define a field as `multipleSelect` as follows:
### For string mode (default mode)
```yaml
children: 
  label: Children
  type: multipleSelect
  mode: string #(optionnal for string mode)
  separator: comma
  options:
    1: option 1
    2: option 2
    3: option 3
```
### For array mode
```yaml
children: 
  label: Children
  type: multipleSelect
  mode: array
  options:
    1: option 1
    2: option 2
    3: option 3
```

### For relation mode
```yaml
children: 
  label: Children
  type: multipleSelect
  mode: relation
  nameFrom: firstname
  keyFrom: id
```

## Contributing
Contributions to the Multiple Select plugin are welcome. Please ensure that your code adheres to the OctoberCMS coding standards and that your code is thoroughly tested before submitting a pull request.
