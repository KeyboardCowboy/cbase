The CSS Directory is organized in the following manner:

- Libraries
  These are third party SASS libraries such as Zen Grids or Bourbon that contain
  site agnostic tools.

- Tools
  Tools are SASS files containing variables, mixins and functions that the
  components rely on to run.  They may be safely imported into child themes
  without the risk of duplicating CSS declarations.

- Components
  Components are purely CSS declarations.  They should not contain any variables
  or other functionality.

Within each of these directories may be subdirectories to better organize large
groups of like files.  Standard naming conventions have not yet been defined.
