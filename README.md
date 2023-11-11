
# Innoscripta Task

This is a simple guide to the Task written by Ahmadreza Youefzad. I should mention that we don't have any access to sites like BBC, NY Times, and NewsRecord because of US sanctions. Therefore, I made some changes to the background of the views (No changes in results!). Hope this finds you well! 



## API Reference

#### Get all items

```http
  GET /API/
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `source` | `string` | `nullable`, `In:database,bbcNews,guardians,newsapi` |
| `category` | `string` | `nullable`, `In:business,entertainment,health,science,sports,technology,other` |
| `key` | `string` | `nullable` |
| `dateFrom` | `string` | `nullable``Format YYYY-MM-DD` |
| `dateTo` | `string` | `nullable``Format YYYY-MM-DD` |
| `author` | `string` | `nullable` |
| `page` | `string` | `nullable`,`number > 0` |
| `pageSize` | `string` | `nullable`,`number > 0` |


## Authors

- [@AhmadrezaYousefzad](https://www.linkedin.com/in/ahmadrezayousefzad)

