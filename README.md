# ExpressionEngine Byline Query Plugin

An ExpressionEngine plugin that checks the "Bylines" channel field for an author's screen name.

This plugin uses an author ID to fetch the author's screen name, checks the "Bylines" channel field for that screen name, and returns matching entry IDs in a "bylines" variable using a format suitable for use by the native Channel addon.

## Usage

Call the plugin with the following syntax:

```mustache
{exp:query_bylines user="{id}" parse="inward"}
    {if bylines != ""}
        {exp:channel:entries entry_id="{bylines}"}
    {/if}
{/exp:query_bylines}
```

If no bylines are found, you can fall back to a traditional entry-ownership model using the fallback parameter:

```mustache
{exp:query_bylines user="{id}" fallback="true" parse="inward"}
    {if bylines != ""}
        {exp:channel:entries entry_id="{bylines}"}
    {/if}
{/exp:query_bylines}
```

Note that you must check for results before passing bylines to the channel module.

## Dependencies

- ExpressionEngine v3+
- A channel field named "Bylines"
