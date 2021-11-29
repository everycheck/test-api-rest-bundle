# Usages

## Test email sending and their content

It is possible with TestApiRestBundle to assert an email has been sent at the end of a request. To do so, use the `mail` key in an test with the expected number of mail sent :

```yaml
    - { url: "/email", status: 201, in: "sendOneEmail", mail: 1 }
```

You are also able to check the content of a sent email by using the `pcre_mail` key. It works just like a RegExp reading through the whole email body.

```yaml
    - { url: "/email", status: 201, in: "sendOneEmail", mail: 1, pcre_mail: '/Lorem Ipsum/'  }
```

When you use a `pcre_email`, variables are created as following the RegExp catcher philosophy. For each group captured, a variable is created with the following pattern : `pcren` with n the number of the group.

Those variables are usable for scenario testing : 

```yaml
scenario:
    pcre_emai_reusing:
      - { action: "POST", url: "/email"       , status: 201, in: "sendOneEmail"      , mail: 1, pcre_mail: '/user id: (.+) name: (.+)/'  }
      - { action: "GET" , url: "/user/#pcre1#/#pcre2#", status: 200}
```

## Test email recipients

There are four ways to verify email recipients:

All recipients:

```yaml
    - { url: "/email", status: 201, in: "sendOneEmail", mail_recipients: "someone@domain.com;someone-else@domain.com"  }
```

Only "To" recipients:

```yaml
    - { url: "/email", status: 201, in: "sendOneEmail", mail_to: "to-someone@domain.com;to-someone-else@domain.com"  }
```

Only "Cc" recipients:

```yaml
    - { url: "/email", status: 201, in: "sendOneEmail", mail_cc: "copy-to-someone@domain.com;copy-to-someone-else@domain.com"  }
```

Only "Bcc" recipients:

```yaml
    - { url: "/email", status: 201, in: "sendOneEmail", mail_bcc: "blind-copy-to-someone@domain.com;blind-copy-to-someone-else@domain.com"  }
```

You can combine them in your test:
```yaml
    - { url: "/email", status: 201, in: "sendOneEmail", mail_to: "to-someone@domain.com", mail_bcc: "blind-copy-to-someone-else@domain.com"  }
```
