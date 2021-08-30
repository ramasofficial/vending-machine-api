# Vending machine API
This is a small guide for vending machine API.

Implemented methods:
* Check vending machine balance
* Add money to vending machine
* Take refund from vending machine
* Select product from vending machine by pences

Original task:
https://github.com/TDD-Katas/vending-machine

# Specify header settings
```
Accept: application/json
```

# Get balance
```
GET YOUR_URL/api/vending-machine/balance/{vending_machine_id}
```

Response:
```
{
    "balance": 0
}
```

# Add balance
```
POST YOUR_URL/api/vending-machine/balance/add/{vending_machine_id}
```

Body:
```
{
    "amount": 100 (int pences)
}
```

Response:
```
{
    "balance": 100,
    "currency": "pences"
}
```

# Take refund
```
GET YOUR_URL/api/vending-machine/refund/{vending_machine_id}
```

Response:
```
{
    "refund": 100,
    "currency": "pences"
}
```

# Select product by pences
```
POST YOUR_URL/api/vending-machine/select-product/{vending_machine_id}
```

Body:
```
{
    "pence": 100 (int pences)
}
```

Response:
```
{
    "selected_product": "BOTTLE OF WATER",
    "current_balance": 100
}
```

# Author
Project structure designed by Ramas, 2021.
